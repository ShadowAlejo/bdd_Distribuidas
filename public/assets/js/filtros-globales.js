// public/assets/js/filtros-globales.js
const FiltrosGlobales = (() => {
    const baseUrl = '/ventas-global/filter';

    async function consultar(filtros) {
        const params = new URLSearchParams();
        for (const [k, v] of Object.entries(filtros || {})) {
            if (v !== undefined && v !== null && String(v).trim() !== '') {
                params.append(k, v);
            }
        }
        const url = params.toString() ? `${baseUrl}?${params}` : baseUrl;

        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });

        // Lee la respuesta cruda para diagnosticar
        const text = await res.text();
        if (!res.ok) {
            console.error('HTTP error global:', res.status, text);
            throw new Error('HTTP ' + res.status);
        }

        // Intenta parsear JSON; si falla, muestra el texto
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error('Respuesta no JSON de ventas-global:', text);
            throw e;
        }
    }

    function renderTabla(data) {
        const tbody = document.querySelector('#tabla-ventas-global tbody');
        if (!tbody) return;
        tbody.innerHTML = '';

        (data || []).forEach((v) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${v.id_ventas_quito ?? ''}</td>
                <td>${v.ciudad ?? ''}</td>
                <td>${v.fecha ?? ''}</td>
                <td>${v.cliente ?? ''}</td>
                <td>${v.monto ?? ''}</td>
                <td>${v.origen_servidor ?? ''}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    return { consultar, renderTabla };
})();
