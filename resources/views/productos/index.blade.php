<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #fafafa;
            color: #1a1a1a;
            line-height: 1.6;
        }
        .container {
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 24px;
        }
        h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 40px;
            letter-spacing: -0.5px;
        }
        .alert {
            padding: 12px 16px;
            margin-bottom: 32px;
            background-color: #f0f0f0;
            border-left: 3px solid #1a1a1a;
            font-size: 14px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            cursor: pointer;
            border: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-primary {
            background-color: #1a1a1a;
            color: white;
        }
        .btn-primary:hover {
            background-color: #000;
        }
        .btn-filter {
            background-color: transparent;
            color: #1a1a1a;
            border: 1px solid #e0e0e0;
            padding: 10px 20px;
        }
        .btn-filter:hover {
            border-color: #1a1a1a;
        }
        .btn-filter.active {
            background-color: #1a1a1a;
            color: white;
            border-color: #1a1a1a;
        }
        .btn-edit {
            background-color: transparent;
            color: #1a1a1a;
            border: 1px solid #e0e0e0;
            padding: 6px 14px;
            font-size: 13px;
        }
        .btn-edit:hover {
            border-color: #1a1a1a;
        }
        .btn-delete {
            background-color: transparent;
            color: #d32f2f;
            border: 1px solid #e0e0e0;
            padding: 6px 14px;
            font-size: 13px;
        }
        .btn-delete:hover {
            border-color: #d32f2f;
            background-color: #fff5f5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border: 1px solid #e0e0e0;
        }
        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        th {
            background-color: #fafafa;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
        }
        td {
            font-size: 14px;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .actions {
            display: flex;
            gap: 8px;
        }
        .actions form {
            display: inline;
        }
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #999;
            font-size: 14px;
        }
        .price {
            font-weight: 500;
        }
        .stock {
            color: #666;
        }
        .stock.high {
            color: #2e7d32;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Productos</h1>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="top-bar">
            <a href="{{ route('productos.create') }}" class="btn btn-primary">Nuevo producto</a>
            
            <div>
                <a href="{{ route('productos.index') }}" class="btn btn-filter {{ !request('stock_alto') ? 'active' : '' }}">
                    Todos
                </a>
                <a href="{{ route('productos.index', ['stock_alto' => '1']) }}" class="btn btn-filter {{ request('stock_alto') ? 'active' : '' }}">
                    Stock Alto
                </a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td class="price">${{ number_format($producto->precio, 2) }}</td>
                        <td class="stock {{ $producto->stock > 5 ? 'high' : '' }}">{{ $producto->stock }}</td>
                        <td>{{ $producto->categoria }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-edit">Editar</a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            No hay productos registrados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>