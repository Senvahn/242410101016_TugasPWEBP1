<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Orders API</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 15px;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success {
            background: #d4edda;
            border-left-color: #28a745;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            border-left-color: #dc3545;
            color: #721c24;
        }
        .warning {
            background: #fff3cd;
            border-left-color: #ffc107;
            color: #856404;
        }
        input[type="text"], input[type="number"], select {
            padding: 8px 12px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
            max-width: 300px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        button.danger {
            background: #dc3545;
        }
        button.danger:hover {
            background: #c82333;
        }
        .response-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-top: 15px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 12px;
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .pending { background: #fff3cd; color: #856404; }
        .confirmed { background: #d4edda; color: #155724; }
        .cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔍 Debug Orders API</h1>
    <p style="color: #666; margin-bottom: 20px;">Tool untuk debugging dan verifikasi API Orders</p>

    <!-- Section 1: Test Search Orders -->
    <div class="section">
        <h2>1️⃣ Test Search Orders API</h2>
        <div class="info-box">
            <strong>Endpoint:</strong> GET /orders/search?query=...
        </div>
        <div>
            <label>Cari berdasarkan (telepon/order_code/nama):</label>
            <input type="text" id="searchQuery" placeholder="Contoh: 08123456789 atau HNY-XXXXX">
            <button onclick="testSearchOrders()">🔎 Test Search</button>
        </div>
        <div id="searchResponse"></div>
    </div>

    <!-- Section 2: Test Get Order Detail -->
    <div class="section">
        <h2>2️⃣ Test Get Order Detail API</h2>
        <div class="info-box">
            <strong>Endpoint:</strong> GET /orders/{id}
        </div>
        <div>
            <label>Order ID:</label>
            <input type="number" id="orderId" placeholder="Contoh: 1" min="1">
            <button onclick="testOrderDetail()">📋 Test Detail</button>
        </div>
        <div id="detailResponse"></div>
    </div>

    <!-- Section 3: List Available Orders -->
    <div class="section">
        <h2>3️⃣ List All Available Orders</h2>
        <div class="info-box">
            Untuk melihat semua order yang tersedia (jika login sebagai admin atau customer)
        </div>
        <button onclick="testListOrders()">📊 Load All Orders</button>
        <div id="ordersListResponse"></div>
    </div>

    <!-- Section 4: Status Check -->
    <div class="section">
        <h2>✅ Route & Config Status</h2>
        <div id="statusResponse"></div>
    </div>
</div>

<script>
    const baseUrl = '{{ url('/') }}';
    const csrfToken = '{{ csrf_token() }}';

    function formatJson(obj) {
        return JSON.stringify(obj, null, 2);
    }

    function showResponse(elementId, data, isError = false) {
        const el = document.getElementById(elementId);
        const statusClass = isError ? 'error' : 'success';
        el.innerHTML = `
            <div class="info-box ${statusClass}">
                <strong>${isError ? '❌ Error:' : '✅ Response:'}</strong>
                <div class="response-box">${formatJson(data)}</div>
            </div>
        `;
    }

    async function testSearchOrders() {
        const query = document.getElementById('searchQuery').value.trim();
        if (!query) {
            alert('Masukkan query pencarian');
            return;
        }

        try {
            const response = await fetch(`${baseUrl}/orders/search?query=${encodeURIComponent(query)}`);
            const data = await response.json();
            showResponse('searchResponse', data, !response.ok);
        } catch (error) {
            showResponse('searchResponse', { error: error.message }, true);
        }
    }

    async function testOrderDetail() {
        const id = document.getElementById('orderId').value.trim();
        if (!id) {
            alert('Masukkan Order ID');
            return;
        }

        try {
            const response = await fetch(`${baseUrl}/orders/${id}`);
            const data = await response.json();
            showResponse('detailResponse', data, !response.ok);
        } catch (error) {
            showResponse('detailResponse', { error: error.message }, true);
        }
    }

    async function testListOrders() {
        try {
            const response = await fetch(`${baseUrl}/orders/search`);
            const data = await response.json();
            
            if (data.data && data.data.length > 0) {
                const html = `
                    <div class="info-box success">
                        <strong>✅ Found ${data.data.length} orders:</strong>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order Code</th>
                                    <th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.data.map(order => `
                                    <tr>
                                        <td><strong>${order.id}</strong></td>
                                        <td>${order.order_code}</td>
                                        <td>${order.nama_pemesan}</td>
                                        <td>${order.telepon || '-'}</td>
                                        <td>Rp ${Number(order.total).toLocaleString('id-ID')}</td>
                                        <td><span class="status-badge ${order.status.toLowerCase()}">${order.status}</span></td>
                                        <td>${order.created_at}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        <div class="info-box" style="margin-top: 15px;">
                            <strong>Gunakan Order ID di atas untuk test Detail API</strong>
                        </div>
                    </div>
                `;
                document.getElementById('ordersListResponse').innerHTML = html;
            } else {
                showResponse('ordersListResponse', data);
            }
        } catch (error) {
            showResponse('ordersListResponse', { error: error.message }, true);
        }
    }

    // Saat page load, check status
    async function checkStatus() {
        const checks = [];
        
        // Check if routes are accessible
        try {
            const response = await fetch(`${baseUrl}/orders/search`);
            checks.push({
                name: 'Orders Search Route',
                status: response.ok ? '✅ OK' : '⚠️ ' + response.status,
                details: response.status
            });
        } catch (e) {
            checks.push({ name: 'Orders Search Route', status: '❌ ERROR', details: e.message });
        }

        const html = `
            <table>
                <thead>
                    <tr>
                        <th>Check</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    ${checks.map(check => `
                        <tr>
                            <td>${check.name}</td>
                            <td>${check.status}</td>
                            <td>${check.details}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
            <div class="info-box" style="margin-top: 15px;">
                <strong>Base URL:</strong> ${baseUrl}
            </div>
        `;
        document.getElementById('statusResponse').innerHTML = html;
    }

    document.addEventListener('DOMContentLoaded', checkStatus);
</script>
</body>
</html>
