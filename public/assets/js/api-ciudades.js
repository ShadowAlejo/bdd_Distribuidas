// public/assets/js/api-ciudades.js

const ApiCiudades = (() => {
    const baseUrl = '/ventas-ciudad';

    async function cargarVentas(ciudad) {
        const url = `${baseUrl}/list?ciudad=${encodeURIComponent(ciudad)}`;
        const res = await fetch(url);
        if (!res.ok) throw new Error('Error al cargar ventas');
        return res.json();
    }

    async function crearVenta(ciudad, datos) {
        const body = new URLSearchParams({ ...datos, ciudad });
        const res = await fetch(`${baseUrl}/store`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body,
        });
        if (!res.ok) throw new Error('Error al crear venta');
        return res.json();
    }

    async function actualizarVenta(ciudad, datos) {
        const body = new URLSearchParams({ ...datos, ciudad });
        const res = await fetch(`${baseUrl}/update`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body,
        });
        if (!res.ok) throw new Error('Error al actualizar venta');
        return res.json();
    }

    async function eliminarVenta(ciudad, id) {
        const body = new URLSearchParams({ ciudad, id });
        const res = await fetch(`${baseUrl}/delete`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body,
        });
        if (!res.ok) throw new Error('Error al eliminar venta');
        return res.json();
    }

    return {
        cargarVentas,
        crearVenta,
        actualizarVenta,
        eliminarVenta,
    };
})();
