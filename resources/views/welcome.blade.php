<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CASH OUT - Accueil</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .container {
            text-align: center;
            padding: 2rem;
        }
        .logo { font-size: 5rem; margin-bottom: 1rem; }
        h1 { font-size: 3rem; margin-bottom: 1rem; }
        p { font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9; }
        .buttons { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
        .btn {
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-primary {
            background: white;
            color: #667eea;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .btn-secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.3);
        }
        .status {
            margin-top: 3rem;
            padding: 1rem;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">💎</div>
        <h1>CASH OUT</h1>
        <p>Plateforme d'investissement intelligent & rentable</p>
        
        <div class="buttons">
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">S'inscrire</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="cursor: pointer;">Déconnexion</button>
                </form>
            @endguest
        </div>

        <div class="status">
            ✅ Application Laravel {{ app()->version() }} - Environnement: {{ config('app.env') }}
        </div>
    </div>
</body>
</html>