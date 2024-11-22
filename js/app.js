document.addEventListener("DOMContentLoaded", function () {
    cargarTareas();

    function cargarTareas() {
        fetch('../php/tasko.php')
            .then(response => response.json())
            .then(data => {
                mostrarTareas(data);
            });
    }

    function mostrarTareas(tareas) {
        const kanbanBoard = document.getElementById('kanban-board');
        // Aquí puedes generar HTML dinámico para cada tarea
    }

    // Ejemplo de agregar una tarea
    document.getElementById("add-task-btn").addEventListener("click", function() {
        const titulo = document.getElementById("task-title").value;
        const descripcion = document.getElementById("task-desc").value;
        const idLista = 1; // Cambia según corresponda

        fetch('../php/tasko.php', {
            method: 'POST',
            body: JSON.stringify({ titulo, descripcion, idLista }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") cargarTareas();
        });
    });
});