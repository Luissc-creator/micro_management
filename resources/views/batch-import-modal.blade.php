<!-- Modal Importazione Task in Batch -->
<div class="modal fade" id="importTaskBatchModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">📤 Importazione Task in Batch</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <h6>🔤 Formato TXT</h6>
            <pre class="bg-light p-2 border">
Titolo Task;Descrizione;Priorità;Scadenza
Sviluppo Frontend;Implementazione UI;media;2023-09-15
Configurazione Database;Setup connessioni;alta;2023-08-30
            </pre>
            <div class="alert alert-info">
              <strong>Formato:</strong> Titolo;Descrizione;Priorità;Scadenza
            </div>
          </div>
          <div class="col-md-6">
            <h6>📄 Formato XML</h6>
            <pre class="bg-light p-2 border">
&lt;tasks&gt;
  &lt;task&gt;
    &lt;titolo&gt;Sviluppo Backend&lt;/titolo&gt;
    &lt;descrizione&gt;Implementazione API REST&lt;/descrizione&gt;
    &lt;priorita&gt;alta&lt;/priorita&gt;
    &lt;scadenza&gt;2023-09-10&lt;/scadenza&gt;
  &lt;/task&gt;
&lt;/tasks&gt;
            </pre>
            <div class="alert alert-info">
              <strong>Formato:</strong> XML con tag task
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">📂 Carica File</label>
          <input type="file" class="form-control" id="batchTaskFile" 
                 accept=".txt,.xml">
        </div>

        <div id="previewImportArea" class="mt-3" style="display:none;">
          <h6>🔍 Anteprima Task</h6>
          <table class="table table-striped" id="previewTaskTable">
            <thead>
              <tr>
                <th>Titolo</th>
                <th>Descrizione</th>
                <th>Priorità</th>
                <th>Scadenza</th>
              </tr>
            </thead>
            <tbody id="previewTaskBody">
              <!-- Anteprima task importati -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-primary" id="importTaskBatchBtn" disabled>
          Importa Task
        </button>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('batchTaskFile').addEventListener('change', function(event) {
  const file = event.target.files[0];
  const previewArea = document.getElementById('previewImportArea');
  const previewBody = document.getElementById('previewTaskBody');
  const importBtn = document.getElementById('importTaskBatchBtn');

  // Reset preview
  previewBody.innerHTML = '';
  previewArea.style.display = 'none';
  importBtn.disabled = true;

  if (file) {
    const reader = new FileReader();
    
    reader.onload = function(e) {
      const content = e.target.result;
      let tasks = [];

      // Rilevamento automatico del formato
      if (file.name.endsWith('.txt')) {
        // Parsing file TXT
        const lines = content.split('\n').filter(line => line.trim() !== '');
        tasks = lines.slice(1).map(line => {
          const [titolo, descrizione, priorita, scadenza] = line.split(';');
          return { titolo, descrizione, priorita, scadenza };
        });
      } else if (file.name.endsWith('.xml')) {
        // Parsing file XML
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(content, 'text/xml');
        const taskElements = xmlDoc.getElementsByTagName('task');
        
        tasks = Array.from(taskElements).map(task => ({
          titolo: task.getElementsByTagName('titolo')[0]?.textContent,
          descrizione: task.getElementsByTagName('descrizione')[0]?.textContent,
          priorita: task.getElementsByTagName('priorita')[0]?.textContent,
          scadenza: task.getElementsByTagName('scadenza')[0]?.textContent
        }));
      }

      // Mostra anteprima
      tasks.forEach(task => {
        const row = previewBody.insertRow();
        row.innerHTML = `
          <td>${task.titolo}</td>
          <td>${task.descrizione}</td>
          <td>
            <span class="badge bg-${
              task.priorita === 'alta' ? 'danger' : 
              (task.priorita === 'media' ? 'warning' : 'success')
            }">
              ${task.priorita === 'alta' ? '🔴' : 
                (task.priorita === 'media' ? '🟡' : '🟢')} 
              ${task.priorita.charAt(0).toUpperCase() + task.priorita.slice(1)}
            </span>
          </td>
          <td>${task.scadenza}</td>
        `;
      });

      previewArea.style.display = 'block';
      importBtn.disabled = false;
    };

    reader.readAsText(file);
  }
});

document.getElementById('importTaskBatchBtn').addEventListener('click', function() {
  const previewBody = document.getElementById('previewTaskBody');
  const taskTable = document.getElementById('taskTable').getElementsByTagName('tbody')[0];

  // Importa i task nella tabella principale
  Array.from(previewBody.rows).forEach(row => {
    const newRow = taskTable.insertRow();
    newRow.innerHTML = row.innerHTML + `
      <td>
        <div class="btn-group btn-group-sm">
          <button class="btn btn-success">✅</button>
          <button class="btn btn-warning">⏸️</button>
          <button class="btn btn-danger">❌</button>
        </div>
      </td>
    `;
  });

  // Chiudi il modal
  const modal = bootstrap.Modal.getInstance(document.getElementById('importTaskBatchModal'));
  modal.hide();

  // Reset file input
  document.getElementById('batchTaskFile').value = '';
});
</script>
