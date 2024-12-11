<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gantt Chart - Gestionale Progetti</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/frappe-gantt@0.6.0/dist/frappe-gantt.css" rel="stylesheet">
  <style>
    .gantt-container {
      width: 100%;
      height: 500px;
      overflow-x: auto;
    }
  </style>
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="freelancer-page.html">Area Freelancer</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="freelancer-page.html">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="tasks.html">Gestione Task</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="gantt.html">Gantt Chart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="work-diary.html">Diario di Lavoro</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="login.html">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <div class="card">
      <div class="card-header">
        <h2>Gantt Chart Progetto</h2>
      </div>
      <div class="card-body">
        <div class="gantt-container">
          <svg id="gantt"></svg>
        </div>
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-header">
        <h3>Dettagli Task</h3>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Task</th>
              <th>Inizio</th>
              <th>Fine</th>
              <th>Stato</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Analisi Requisiti</td>
              <td>2023-08-01</td>
              <td>2023-08-10</td>
              <td>🟢 Completato</td>
            </tr>
            <tr>
              <td>Progettazione UI</td>
              <td>2023-08-11</td>
              <td>2023-08-20</td>
              <td>🟡 In Corso</td>
            </tr>
            <tr>
              <td>Sviluppo Backend</td>
              <td>2023-08-21</td>
              <td>2023-09-10</td>
              <td>🔴 Non Iniziato</td>
            </tr>
            <tr>
              <td>Test e Debugging</td>
              <td>2023-09-11</td>
              <td>2023-09-25</td>
              <td>⚪ Pianificato</td>
            </tr>
            <tr>
              <td>Deployment</td>
              <td>2023-09-26</td>
              <td>2023-10-05</td>
              <td>⚪ Pianificato</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Librerie JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/frappe-gantt@0.6.0/dist/frappe-gantt.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tasks = [
        {
          id: 'Analisi',
          name: 'Analisi Requisiti',
          start: '2023-08-01',
          end: '2023-08-10',
          progress: 100,
          dependencies: ''
        },
        {
          id: 'UI',
          name: 'Progettazione UI',
          start: '2023-08-11',
          end: '2023-08-20',
          progress: 50,
          dependencies: 'Analisi'
        },
        {
          id: 'Backend',
          name: 'Sviluppo Backend',
          start: '2023-08-21',
          end: '2023-09-10',
          progress: 0,
          dependencies: 'UI'
        },
        {
          id: 'Test',
          name: 'Test e Debugging',
          start: '2023-09-11',
          end: '2023-09-25',
          progress: 0,
          dependencies: 'Backend'
        },
        {
          id: 'Deploy',
          name: 'Deployment',
          start: '2023-09-26',
          end: '2023-10-05',
          progress: 0,
          dependencies: 'Test'
        }
      ];

      const gantt = new Gantt("#gantt", tasks, {
        view_mode: 'Week',
        language: 'it',
        custom_popup_html: (task) => {
          return `
            <div class="details-container">
              <h5>${task.name}</h5>
              <p>Inizio: ${task.start}</p>
              <p>Fine: ${task.end}</p>
              <p>Progresso: ${task.progress}%</p>
            </div>
          `;
        }
      });
    });
  </script>
</body>
</html>
