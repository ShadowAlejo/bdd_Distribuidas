// public/assets/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    console.log('Dashboard listo');

    // --- Navegación de tabs: debe funcionar aunque falle el CRUD ---
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-tab');

            tabButtons.forEach((btn) => btn.classList.remove('is-active'));
            button.classList.add('is-active');

            tabContents.forEach((section) => {
                if (section.id === `tab-${targetId}`) {
                    section.classList.add('is-active');
                } else {
                    section.classList.remove('is-active');
                }
            });
        });
    });

    // --- Selector de ciudad + CRUD ---
    const selectorCiudad = document.getElementById('selector-ciudad');
    const tablaBody = document.querySelector('#tabla-ventas-ciudad tbody');
    const form = document.getElementById('form-venta-ciudad');

    // Si falta algo del DOM, no seguimos con CRUD
    if (!selectorCiudad || !tablaBody || !form) {
        console.warn('Elementos de CRUD por ciudad no encontrados en el DOM');
        return;
    }

    // Si ApiCiudades aún no existe (por orden de <script>), no rompemos la app
    if (typeof ApiCiudades === 'undefined') {
        console.warn('ApiCiudades no está definido. Revisa el orden de los <script>.');
        return;
    }

    async function refrescarTabla() {
        const ciudad = selectorCiudad.value;
        try {
            const respuesta = await ApiCiudades.cargarVentas(ciudad);
            const ventas = respuesta.data || [];
            tablaBody.innerHTML = '';

            ventas.forEach((v) => {
                const id =
                    v.id ??
                    v.id_ventas_quito ??
                    v.id_ventas_cuenca ??
                    v.id_ventas_guayaquil ??
                    v.idventasquito ??
                    v.idventascuenca ??
                    v.idventasguayaquil ??
                    '';

                const tr = document.createElement('tr');
                tr.dataset.id = id;

                tr.innerHTML = `
                    <td>${id}</td>
                    <td>${v.fecha}</td>
                    <td>${v.cliente}</td>
                    <td>${v.monto}</td>
                    <td>
                        <button class="btn-editar">Editar</button>
                        <button class="btn-eliminar">Eliminar</button>
                    </td>
                `;
                tablaBody.appendChild(tr);
            });
        } catch (e) {
            console.error(e);
            alert('Error al cargar ventas');
        }
    }

    selectorCiudad.addEventListener('change', () => {
        const inputCiudad = document.getElementById('venta-ciudad');
        if (inputCiudad) {
            inputCiudad.value = selectorCiudad.value;
        }
        refrescarTabla();
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const ciudad = selectorCiudad.value;
        const id = form.querySelector('#venta-id').value;
        const datos = {
            id,
            fecha: form.querySelector('#venta-fecha').value,
            cliente: form.querySelector('#venta-cliente').value,
            monto: form.querySelector('#venta-monto').value,
        };

        try {
            if (id) {
                await ApiCiudades.actualizarVenta(ciudad, datos);
            } else {
                await ApiCiudades.crearVenta(ciudad, datos);
            }
            limpiarFormulario();
            await refrescarTabla();
        } catch (e) {
            console.error(e);
            alert('Error al guardar venta');
        }
    });

    function limpiarFormulario() {
        form.reset();
        form.querySelector('#venta-id').value = '';
    }

    document.getElementById('btn-limpiar')?.addEventListener('click', () => {
        limpiarFormulario();
    });

    // Delegación de eventos para editar/eliminar
    tablaBody.addEventListener('click', async (e) => {
        const target = e.target;
        if (target.classList.contains('btn-editar')) {
            const tr = target.closest('tr');
            const celdas = tr.querySelectorAll('td');
            const id = tr.dataset.id;
            form.querySelector('#venta-id').value = id;
            form.querySelector('#venta-fecha').value = celdas[1].textContent.trim();
            form.querySelector('#venta-cliente').value = celdas[2].textContent.trim();
            form.querySelector('#venta-monto').value = celdas[3].textContent.trim();
        }

        if (target.classList.contains('btn-eliminar')) {
            if (!confirm('¿Eliminar esta venta?')) return;
            const tr = target.closest('tr');
            const id = tr.dataset.id;
            const ciudad = selectorCiudad.value;
            try {
                await ApiCiudades.eliminarVenta(ciudad, id);
                await refrescarTabla();
            } catch (err) {
                console.error(err);
                alert('Error al eliminar venta');
            }
        }
    });

    // Cargar datos iniciales
    refrescarTabla();
});


// --- Reportes globales ---
const formFiltros = document.getElementById('form-filtros-globales');
const btnLimpiarFiltros = document.getElementById('btn-limpiar-filtros');

// Verifica disponibilidad del módulo
if (typeof FiltrosGlobales === 'undefined') {
    console.warn('FiltrosGlobales no está definido. Revisa el orden de los <script>.');
}

async function cargarGlobalInicial() {
    try {
        const resp = await FiltrosGlobales.consultar({});
        // Depuración: si algo va mal, ver el objeto completo
        console.debug('Global inicial:', resp);
        FiltrosGlobales.renderTabla(resp.data || []);
    } catch (e) {
        console.error('Error cargarGlobalInicial:', e);
        alert('Error al cargar ventas globales');
    }
}

if (formFiltros && typeof FiltrosGlobales !== 'undefined') {
    formFiltros.addEventListener('submit', async (e) => {
        e.preventDefault();

        const filtros = {
            ciudad: formFiltros.querySelector('#filtro-ciudad-global')?.value || '',
            cliente: formFiltros.querySelector('#filtro-cliente-global')?.value || '',
            fecha_desde: formFiltros.querySelector('#filtro-fecha-desde')?.value || '',
            fecha_hasta: formFiltros.querySelector('#filtro-fecha-hasta')?.value || '',
            monto_order: document.getElementById('filtro-monto-order').value,
        };

        try {
            const resp = await FiltrosGlobales.consultar(filtros);
            console.debug('Global filtrado:', filtros, resp);
            FiltrosGlobales.renderTabla(resp.data || []);
        } catch (err) {
            console.error('Error aplicar filtros:', err);
            alert('Error al aplicar filtros');
        }
    });
}

btnLimpiarFiltros?.addEventListener('click', async () => {
    formFiltros?.reset();
    await cargarGlobalInicial();
});

// Carga inicial solo si el módulo existe
if (typeof FiltrosGlobales !== 'undefined') {
    cargarGlobalInicial();
}
