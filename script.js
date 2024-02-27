// Obtener referencia al formulario y al div de resultados
const searchForm = document.getElementById('searchForm');
const resultsDiv = document.getElementById('results');

// Agregar un evento de escucha para el envío del formulario
searchForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío tradicional del formulario
    const formData = new FormData(this); // Obtener datos del formulario

    fetch('search.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        displayResults(data);
    })
    .catch(error => console.error('Error:', error));
});

function displayResults(data) {
    var resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';

    if (data.error) {
        resultsDiv.innerHTML = '<p>' + data.error + '</p>';
    } else if (data.length === 0) {
        resultsDiv.innerHTML = '<p>No se encontraron viviendas que coincidan con los criterios de búsqueda.</p>';
    } else {
        var ul = document.createElement('ul');
        data.forEach(function(vivienda) {
            var li = document.createElement('li');
            li.textContent = `Precio: ${vivienda.precio}, Habitaciones: ${vivienda.habitaciones}, Fecha de construcción: ${vivienda.fecha_construccion}`;
            ul.appendChild(li);
        });
        resultsDiv.appendChild(ul);
    }
}
