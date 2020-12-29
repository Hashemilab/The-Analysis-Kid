// Short way to get element by id.
function _(el) {
return document.getElementById(el);
}
/** Create a heap array from the array ar. */
function allocFromArray(ar) {
let heapArray = alloc(ar.length * ar.BYTES_PER_ELEMENT);
heapArray.set(new Uint8Array(ar.buffer));
return heapArray;
};
/** Allocate a heap array to be passed to a compiled function. */
function alloc(nbytes) {
return new Uint8Array(Module.HEAPU8.buffer, Module._malloc(nbytes), nbytes);
};
/** Free a heap array. */
function free(heapArray) {Module._free(heapArray.byteOffset)};

function get_data_from_heap(heap, size){
let tmp = new Float32Array(size); tmp.set(new Float32Array(Module.HEAPU8.buffer, heap.byteOffset, size));
return tmp;
};
