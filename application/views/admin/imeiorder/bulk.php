<style>
    .bulk-header {
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 50%, #0ea5e9 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 6px 25px rgba(139, 92, 246, 0.3);
    }
    
    .bulk-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 900;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .bulk-controls {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .bulk-control-group {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: white;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
    }
    
    .bulk-control-group label {
        font-weight: 600;
        font-size: 12px;
        color: #475569;
        margin: 0;
    }
    
    .bulk-control-group input,
    .bulk-control-group select {
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 13px;
        min-width: 150px;
    }
    
    .bulk-btn {
        padding: 10px 20px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
    }
    
    .bulk-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .bulk-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .bulk-table thead th {
        background: linear-gradient(135deg, #475569, #334155);
        color: white;
        padding: 12px;
        text-align: left;
        font-weight: 700;
        font-size: 13px;
        border-bottom: 2px solid #1e293b;
    }
    
    .bulk-table tbody td {
        padding: 10px;
        border-bottom: 1px solid #e2e8f0;
        background: white;
    }
    
    .bulk-table tbody tr:hover {
        background: #f8fafc;
    }
    
    .bulk-table input[type="text"],
    .bulk-table select {
        width: 100%;
        padding: 8px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 13px;
    }
    
    .bulk-table input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #8b5cf6;
    }
    
    .submit-section {
        margin-top: 25px;
        padding: 20px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border-radius: 12px;
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
    
    .btn-submit {
        padding: 12px 30px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
    }
    
    .info-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    
    .badge-issued {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .badge-canceled {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
</style>

<div class="workplace">                             
    <div class="row-fluid">
        <div class="span12">
          <?php $this->load->view('admin/includes/message'); ?>
          <?php echo form_open('admin/imeiorder/bulk_operation',array('method' => 'post','id'=>'form')); ?>
          
          <div class="bulk-header">
              <h1>✏️ Edición Masiva de Órdenes IMEI</h1>
              <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Edita múltiples órdenes simultáneamente</p>
          </div>
          
          <!-- Controles Masivos -->
          <div class="bulk-controls">
              <div class="bulk-control-group">
                  <label>📝 Rellenar Código:</label>
                  <input type="text" id="fill_code" placeholder="Aplicar a todas..." />
                  <button type="button" class="bulk-btn" onclick="fillAll('code')">Aplicar</button>
              </div>
              
              <div class="bulk-control-group">
                  <label>💬 Rellenar Comentarios:</label>
                  <input type="text" id="fill_comments" placeholder="Aplicar a todas..." />
                  <button type="button" class="bulk-btn" onclick="fillAll('comments')">Aplicar</button>
              </div>
              
              <div class="bulk-control-group">
                  <label>🔄 Cambiar Estado:</label>
                  <select id="fill_status">
                      <option value="">-- Mantener --</option>
                      <option value="Pending">Pending</option>
                      <option value="Issued">Issued</option>
                      <option value="Canceled">Canceled</option>
                  </select>
                  <button type="button" class="bulk-btn" onclick="fillAll('status')">Aplicar</button>
              </div>
              
              <div class="bulk-control-group">
                  <label>📧 Rellenar Email:</label>
                  <input type="email" id="fill_email" placeholder="Aplicar a todas..." />
                  <button type="button" class="bulk-btn" onclick="fillAll('email')">Aplicar</button>
              </div>
          </div>
          
          <div class="block-fluid table-sorting clearfix">
              <table cellpadding="0" cellspacing="0" width="100%" class="table bulk-table">
                  <thead>
                      <tr>
                          <th width="3%">Refund<br/><input type="checkbox" id="checkall_refund" title="Seleccionar todos"/></th>
                          <th width="5%">ID</th>
                          <th width="12%">IMEI</th>
                          <th width="20%">Method</th>
                          <th width="15%">Email</th>
                          <th width="8%">Status</th>
                          <th width="20%">Code</th>
                          <th width="17%">Comments</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                      $method_list_edit = array(''=>'-- Mantener --');
                      foreach ($this->method_model->get_all() as $value) {
                          $method_list_edit[$value['ID']] = $value['Title'];
                      }
                      foreach($data as $value): 
                          $id = $value['ID'];
                          $status_class = '';
                          if($value['Status'] == 'Pending') $status_class = 'badge-pending';
                          elseif($value['Status'] == 'Issued') $status_class = 'badge-issued';
                          elseif($value['Status'] == 'Canceled') $status_class = 'badge-canceled';
                      ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="refund[]" value="<?php echo $id; ?>" class="refund-checkbox"/>
                            </td>
                            <td><?php echo $id; ?></td>
                            <td><strong><?php echo htmlspecialchars($value['IMEI']); ?></strong></td>
                            <td>
                                <select name="MethodID[<?php echo $id; ?>]" class="method-select" style="width: 100%;">
                                    <option value="">-- Mantener Actual --</option>
                                    <?php foreach($method_list_edit as $mid => $mtitle): ?>
                                        <option value="<?php echo $mid; ?>" <?php echo ($mid == $value['MethodID']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($mtitle); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="email" name="Email[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($value['Email']); ?>" class="email-field" />
                            </td>
                            <td>
                                <select name="Status[<?php echo $id; ?>]" class="status-select">
                                    <option value="">-- Mantener --</option>
                                    <option value="Pending" <?php echo ($value['Status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Issued" <?php echo ($value['Status'] == 'Issued') ? 'selected' : ''; ?>>Issued</option>
                                    <option value="Canceled" <?php echo ($value['Status'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="Code[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($value['Code'] ?? ''); ?>" class="codes" placeholder="Código..." />
                            </td>
                            <td>
                                <input type="text" name="Comments[<?php echo $id; ?>]" value="<?php echo htmlspecialchars($value['Comments'] ?? ''); ?>" class="comments" placeholder="Comentarios..." />
                            </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
          
          <div class="submit-section">
              <button type="button" class="btn" onclick="window.history.back();" style="padding: 12px 24px; background: #64748b; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                  ← Cancelar
              </button>
              <?php echo form_submit(array('value'=> '✅ Guardar Cambios','class'=>'btn-submit')); ?>
          </div>
          
          <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // Seleccionar todos para refund
    $('#checkall_refund').on('change', function() {
        $('.refund-checkbox').prop('checked', this.checked);
    });
});

function fillAll(field) {
    var value;
    
    switch(field) {
        case 'code':
            value = $('#fill_code').val();
            $('.codes').val(value);
            break;
        case 'comments':
            value = $('#fill_comments').val();
            $('.comments').val(value);
            break;
        case 'status':
            value = $('#fill_status').val();
            if(value) {
                $('.status-select').val(value);
            }
            break;
        case 'email':
            value = $('#fill_email').val();
            if(value) {
                $('.email-field').val(value);
            }
            break;
    }
    
    // Feedback visual
    if(value || field === 'status') {
        alert('✅ ' + (field === 'status' && value ? 'Estado aplicado' : field === 'code' ? 'Código aplicado' : field === 'comments' ? 'Comentarios aplicados' : 'Email aplicado') + ' a todas las órdenes');
    }
}
</script>
           