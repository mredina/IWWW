function showMenu() {
    // najde prvni prvek se tag jmenem nav a vrati ho do promenne
    let el = document.getElementsByTagName("nav")[0];
    // pridava a odebira classu
    el.classList.toggle('responsive');
}