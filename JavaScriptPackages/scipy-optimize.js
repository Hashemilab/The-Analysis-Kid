(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
var scipy = require('scipy-optimize');

},{"scipy-optimize":3}],2:[function(require,module,exports){

},{}],3:[function(require,module,exports){
var eng = require('./node/engine');

var index = module.exports = {
  localMinimize: function(func, options, callback) {
    eng.runPython('local', func, options, callback);
  },
  globalMinimize: function(func, options, callback) {
    eng.runPython('global', func, options, callback);
  },  
  minimizeEuclideanNorm: function(A, b, callback) {
    eng.runPython('nnls', A, b, callback);
  },
  fitCurve: function(func, xData, yData, options, callback) {
    eng.runPython('fit', func, options, callback, xData, yData);
  },
  findRoot: function(func, lower, upper, options, callback) {
    eng.runPython('root', func, options, callback, lower, upper);
  },
  findVectorRoot: function(func, guess, options, callback) {
    eng.runPython('vectorRoot', func, options, callback, guess);
  },
  calcDerivatives: function(func, point, options, callback) {
    eng.runPython('derivative', func, options, callback, point);
  }
};

index.fitCurve.linear = function(xData, yData, callback) {
  eng.runPython('fit', 'a * x + b', { variables: ['x', 'a', 'b'] }, callback, xData, yData);
};

index.fitCurve.quadratic = function(xData, yData, callback) {
  eng.runPython('fit', 'a * (x**2) + b * x + c', { variables: ['x', 'a', 'b', 'c'] }, callback, xData, yData);
};

},{"./node/engine":5}],4:[function(require,module,exports){
var parse = require('./parse');

var globalDefaults = {
  guess:               0,
  iterations:          100,
  temperature:         1.0,
  stepSize:            0.5,
  includeAllMinsFound: false,
  interval:            50
};

var extendNoOverwrite = function (obj, defaults){
  for (key in defaults) {
    if (obj[key] === undefined) {
      obj[key] = defaults[key];
    }
  }
}

var optionalArgs = function (options, callback) {
  if (typeof options === 'function') {
    callback = options;
    options = undefined;
  }
  // provide default callback function (console.log)
  callback = cleanInputs.cleanCB(callback);

  options = options || {};

  return {
    callback: callback,
    options: options
  };
};

var cleanInputs = module.exports = {
  cleanMin: function (operation, func, options, callback) {
    var optional = optionalArgs(options, callback);
    options  = optional.options;
    callback = optional.callback;

    // clean provided function to be accepted by sympy lambdify function
    func = parse.cleanFunc(func, options.variable, false).func;
    // provide sensible defaults for the options object
    if (operation === 'local') {
      options = {
        bracket: null,
        method: 'Brent',
        bounds: options.bounds,
        tol: null,
        options: null
      }

      if (Array.isArray(options.bounds) && options.bounds.length === 2) {
        options.method = 'Bounded';
      } else {
        options.bounds = null;
        options.method = 'Brent';
      }
    } else if (operation === 'global') {
      extendNoOverwrite(options, globalDefaults);
    }

    return {
      func:     func,
      options:  options,
      callback: callback
    }
  },

  cleanFit: function(func, options, callback, xData, yData) {
    var optional = optionalArgs(options, callback);
    options  = optional.options;
    callback = optional.callback;

    options.xData = xData;
    options.yData = yData;

    f = parse.cleanFunc(func, options.variables, true);
    options.numArgs = f.numArgs;
    func = f.func;

    return {
      func:     func,
      options:  options,
      callback: callback
    }
  },

  cleanRoot: function(func, options, callback, lower, upper) {
    var optional = optionalArgs(options, callback);
    options  = optional.options;
    callback = optional.callback;

    options.lower = lower;
    options.upper = upper;
    options.method = options.method || 'brentq'

    func = parse.cleanFunc(func, options.variable, false).func;

    return {
      func:     func,
      options:  options,
      callback: callback
    }
  },

  cleanVector: function(func, options, callback, guess) {
    var optional = optionalArgs(options, callback);
    options  = optional.options;
    callback = optional.callback;

    options.guess = guess;

    func = parse.cleanFunc(func, options.variable, false).func;

    return {
      func:     func,
      options:  options,
      callback: callback
    }
  },

  cleanDerivative: function(func, options, callback, point) {
    var optional = optionalArgs(options, callback);
    options  = optional.options;
    callback = optional.callback;

    options.point = point;
    options.epsilon = options.epsilon || Math.pow(10, -9);

    func = parse.cleanFunc(func, options.variable, false).func;
    return {
      func:     func,
      options:  options,
      callback: callback
    }
  },

  cleanCB: function (callback){
    return callback || function (results){
      console.log(results);
    };
  }
}
},{"./parse":6}],5:[function(require,module,exports){
(function (__dirname){(function (){
var clean = require('./clean');

module.exports = Engine = {};

Engine.runPython = function(operation, a, b, cb, x, y) {
  if (operation === 'local' || operation === 'global') {
    var cleanup = clean.cleanMin(operation, a, b, cb);
    a   = cleanup.func;
    b = JSON.stringify(cleanup.options);
    cb  = cleanup.callback;
  } else if (operation === 'nnls') {
    cb = clean.cleanCB(cb);
    a = JSON.stringify(a);
    b = JSON.stringify(b);
  } else if (operation === 'fit') {
    var cleanup = clean.cleanFit(a, b, cb, x, y);
    a = cleanup.func;
    b = JSON.stringify(cleanup.options);
    cb = cleanup.callback;
  } else if (operation === 'root') {
    var cleanup = clean.cleanRoot(a, b, cb, x, y);
    a = cleanup.func;
    b = JSON.stringify(cleanup.options);
    cb = cleanup.callback;
  } else if (operation === 'vectorRoot') {
    var cleanup = clean.cleanVector(a, b, cb, x);
    a = cleanup.func;
    b = JSON.stringify(cleanup.options);
    cb = cleanup.callback;
  } else if (operation === 'derivative') {
    var cleanup = clean.cleanDerivative(a, b, cb, x);
    a = cleanup.func;
    b = JSON.stringify(cleanup.options);
    cb = cleanup.callback;
  }

  // don't need to worry about race conditions with async process below
  // since each is wrapped in their own "runPython" closure
  var python = require('child_process').spawn(
  'python',
  [__dirname + '/../py/exec.py', operation, a, b]);
  var output = '';
  python.stdout.on('data', function (data){
    output += data;
  });
  python.stdout.on('close', function (){
    try {
      cb(JSON.parse(output));
    } catch (e) {
      cb(output);
    }
  });
}

}).call(this)}).call(this,"/node_modules/scipy-optimize/node")
},{"./clean":4,"child_process":2}],6:[function(require,module,exports){
var Parser = module.exports = {};

Parser.extractFromFunction = function (func, multipleParams) {
  // if function given is a function,
  // extract the argument name, extract the return value,
  // replace the argument name with 'x'
  // return the return value as a string, with x as the independent variable
  func = func.toString();
  var args;
  if (!multipleParams) {
    var arg = func.match(/^function\s*[^\(]*\(\s*([^\)\,]*)[\,\)]/m)[1];
    var regex = new RegExp('\\b' + arg.trim() + '\\b', 'g')
    func = func.replace(regex, 'x');
  } else {
    // args are going to be f(x, a, b, c...) - x is independent variable, a, b... are parameters
    args = func.match(/^function\s*[^\(]*\(\s*([^\)]*)[\)]/m)[1];
    args = args.split(',');
    var ch = 'a';
    for (var i = 0; i < args.length; i++) {
      var regex = new RegExp('\\b' + args[i].trim() + '\\b', 'g');
      if (i === 0) {
        func = func.replace(regex, 'x');
      } else {
        func = func.replace(regex, ch);
        ch = String.fromCharCode(ch.charCodeAt(0) + 1);
      }
    }
  }
  func = func.match(/return\s*([^\;}]*)[\;}]/m)[1];
  args = args || {};
  return {
    func   : func, 
    numArgs: args.length
  }
};

Parser.extractFromString = function (func, newVarName, multipleParams) {
  if (newVarName && typeof newVarName === 'string' && !multipleParams) {
    var regex = new RegExp('\\b' + newVarName + '\\b', 'g');
    func = func.replace(regex, 'x');
    return {
      func: func,
      numArgs: 1
    };
  } else if (newVarName && typeof newVarName === 'object' && multipleParams) {
    numArgs = newVarName.length;
    var ch = 'a';
    for (var i = 0; i < newVarName.length; i++) {
      var regex = new RegExp('\\b' + newVarName[i] + '\\b', 'g');
      if (i === 0) {
        func = func.replace(regex, 'x');
      } else {
        func = func.replace(regex, ch);
        ch = String.fromCharCode(ch.charCodeAt(0) + 1);
      }
    }
    return {
      func: func,
      numArgs: numArgs
    }
  }
}

Parser.cleanFunc = function (func, newVarName, multipleParams){
  var f;
  if (typeof func === 'function') {
    f = Parser.extractFromFunction(func, multipleParams);
  } else if (typeof func === 'string') {
    f = Parser.extractFromString(func, newVarName, multipleParams);
  } else {
    throw 'function to be optimized needs to be a function or a string expression';
  }
  func = f.func;
  var numArgs = f.numArgs;

  func = func.replace(/Math./gi,'');
  func = func.replace(/LN2/gi, 'ln(2)');
  func = func.replace(/LN10/gi, 'ln(10)');
  func = func.replace(/LOG2E/gi, 'log(e,2)');
  func = func.replace(/LOG10E/gi, 'log(e,10)');
  func = func.replace(/SQRT1_2/gi, 'sqrt(1/2)');
  func = func.replace(/SQRT2/gi, 'sqrt(2)');
  func = func.toLowerCase();

  return {
    func   : func,
    numArgs: numArgs
  };
}
},{}]},{},[1]);
