<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selezione Utente - Gestionale Progetti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .user-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .user-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-center mb-4">
                    <h1>🏢 Culture Digitali</h1>
                    <p class="lead">Seleziona il tipo di utente</p>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card user-card" data-user="admin">
                            <div class="card-body text-center">
                                <h2>🔧 Amministratore</h2>
                                <p class="text-muted">Gestione completa del sistema</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card user-card" data-user="operator">
                            <div class="card-body text-center">
                                <h2>💻 Operatore</h2>
                                <p class="text-muted">Gestione progetti e task</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card user-card" data-user="client">
                            <div class="card-body text-center">
                                <h2>👥 Cliente</h2>
                                <p class="text-muted">Visualizzazione progetto</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Aggiungi event listener a tutti i card
        document.querySelectorAll('.user-card').forEach(card => {
            card.addEventListener('click', function() {
                // Prendi il tipo di utente dal data attribute
                const userType = this.getAttribute('data-user');

                // Imposta il tipo di utente nella sessione
                sessionStorage.setItem('userType', userType);

                // Reindirizza alla pagina corrispondente
                const redirects = {
                    'admin': 'view/admin/dashboard',
                    'operatore': 'view/operator/dashboard',
                    'cliente': 'view/client/dashboard'
                };

                window.location.href = '/login/' + userType;
            });
        });
    </script>
</body>

</html>
