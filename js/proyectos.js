// Elementos del DOM
const btnAddProject = document.getElementById('btn-add-p');
const btnSaveProject = document.getElementById('btn-guardar-p');
const projectContainer = document.getElementById('p-container');

const modal = new bootstrap.Modal(document.getElementById('crear-p-modal'));

// Función para agregar un nuevo proyecto al contenedor
function addNewProject(name, description) {
    const newCard = document.createElement('div');
    newCard.classList.add('col-md-4', 'mb-4');
    newCard.innerHTML = `
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">${name}</h5>
                <p class="card-text">${description}</p>
                <a href="#" class="btn btn-standard" id="g-tarea">Gestionar Tareas</a>
                <button class="btn btn-dark btn-del-p">Eliminar</button>
            </div>
        </div>
    `;
    projectContainer.appendChild(newCard);

    // Asignar la funcionalidad de eliminar
    const deleteButton = newCard.querySelector('.btn-del-p');
    deleteButton.addEventListener('click', () => {
        const projectCard = deleteButton.closest('.col-md-4');
        if (confirm('¿Estás seguro de que deseas eliminar este proyecto?')) {
            projectCard.remove();
            // Opcional: Aquí podrías hacer una llamada AJAX para eliminar de la base de datos
        }
    });
}

// Abrir modal para añadir proyecto
btnAddProject.addEventListener('click', () => {
    modal.show();
});

// Guardar nuevo proyecto
btnSaveProject.addEventListener('click', () => {
    const name = document.getElementById('p-nombre').value.trim();
    const description = document.getElementById('p-descripcion').value.trim();

    if (name && description) {
        // Enviar los datos al servidor para guardarlos en la base de datos
        fetch('/tasko-plan/php/php-controllers/crearProyecto.php', {  // Cambié la URL a 'crearProyecto.php'
            method: 'POST',
            body: new URLSearchParams({
                'nombre': name,
                'descripcion': description
            })
        })
        .then(response => response.text())
        .then(data => {
            // Verificar que el servidor haya respondido correctamente (por ejemplo, "Proyecto guardado")
            if (data === 'Proyecto guardado') {
                // Agregar el nuevo proyecto al DOM solo si la inserción fue exitosa
                addNewProject(name, description);

                // Limpiar el formulario y cerrar el modal
                document.getElementById('p-nombre').value = '';
                document.getElementById('p-descripcion').value = '';
                modal.hide();

                // Mostrar un mensaje de éxito
                alert('Proyecto guardado exitosamente!');
            } else {
                alert('Hubo un error al guardar el proyecto.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al guardar el proyecto.');
        });
    } else {
        alert('Por favor, completa ambos campos.');
    }
});

// Eliminar proyecto existente (aplica para los proyectos iniciales ya cargados)
document.querySelectorAll('.btn-del-p').forEach(button => {
    button.addEventListener('click', event => {
        const projectCard = event.target.closest('.col-md-4');
        const projectId = projectCard.getAttribute('data-id-proyecto');

        // Confirmar eliminación
        if (confirm('¿Estás seguro de que deseas eliminar este proyecto?')) {
            projectCard.remove();
            // Opcional: Aquí podrías realizar una llamada AJAX para eliminar de la base de datos
        }
    });
});
