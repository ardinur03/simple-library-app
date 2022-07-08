/* Konfirmasi Sebelum Hapus */
var elems = document.getElementsByClassName('confirm');
var confirmIt = function(e) {
    if (!confirm('Apakah yakin akan dihapus?')) e.preventDefault();
};

for (let i = 0, l = elems.length; i < l; i++) {
    elems[i].addEventListener('click', confirmIt, false);
}

/* Konfirmasi Sebelum Hapus */
let elm = document.getElementsByClassName('confirm-batal');
let confirBp = function(e) {
    if (!confirm('Apakah yakin akan membatalkan pengembalian ?')) e.preventDefault();
};

for (let i = 0, l = elm.length; i < l; i++) {
    elm[i].addEventListener('click', confirBp, false);
}


$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})