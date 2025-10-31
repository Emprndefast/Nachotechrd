<div class="dashboard">
<div class="row">
<div class="col-lg-12">
  <h2>Server / Tools Services</h2>
</div>
</div>

<style>
/* Search Bar Styles */
.search-bar-container {
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
    border-radius: 16px;
    padding: 30px;
    margin: 25px 0;
    box-shadow: 0 8px 25px rgba(139, 92, 246, 0.25);
}

.search-wrapper {
    position: relative;
    max-width: 600px;
    margin: 0 auto;
}

.search-input {
    width: 100%;
    padding: 16px 50px 16px 50px;
    font-size: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    transition: all 0.3s;
    color: #0f172a;
    font-weight: 600;
}

.search-input:focus {
    outline: none;
    border-color: #fff;
    background: #fff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.search-input::placeholder {
    color: #94a3b8;
    font-weight: 500;
}

.search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    color: #64748b;
}

.clear-search {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    background: #ef4444;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    display: none;
    transition: all 0.3s;
}

.clear-search:hover {
    background: #dc2626;
    transform: translateY(-50%) scale(1.1);
}

.search-stats {
    text-align: center;
    margin-top: 15px;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
}

.search-stats span {
    background: rgba(255, 255, 255, 0.2);
    padding: 5px 12px;
    border-radius: 20px;
    margin: 0 5px;
}

/* Cards Grid */
.server-card-grid { 
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px; 
    margin-bottom: 30px; 
}

.server-card { 
    background: linear-gradient(135deg, #fafafa 0%, #fff 100%); 
    border: 2px solid #e9d5ff; 
    border-radius: 14px; 
    padding: 22px; 
    cursor: pointer; 
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.server-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s;
}

.server-card:hover::before {
    opacity: 1;
}

.server-card:hover { 
    box-shadow: 0 8px 35px rgba(139, 92, 246, 0.3); 
    border-color: #8b5cf6; 
    background: #fff;
    transform: translateY(-5px);
}

.server-card.hidden {
    display: none;
}

.server-serv-title { 
    font-size: 18px; 
    font-weight: 800; 
    color: #0f172a; 
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
}

.server-serv-details { 
    font-size: 14px; 
    color: #64748b; 
    font-weight: 500;
    line-height: 1.5;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.server-price-chip { 
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); 
    color: #fff; 
    padding: 4px 12px; 
    border-radius: 10px; 
    font-size: 14px; 
    font-weight: 800; 
    display: inline-block; 
    margin-bottom: 5px; 
    margin-right: 8px;
    box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3);
}

.server-delivery { 
    font-size: 13px; 
    color: #1e293b; 
    margin-top: 8px;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

/* No Results */
.no-results {
    display: none;
    text-align: center;
    padding: 60px 30px;
    background: #f8fafc;
    border-radius: 16px;
    margin: 30px 0;
}

.no-results.active {
    display: block;
}

.no-results-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.no-results-text {
    font-size: 20px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 10px;
}

.no-results-subtext {
    font-size: 15px;
    color: #94a3b8;
}

/* Modal Styles */
.server-modal-overlay { 
    display: none; 
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.7);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center; 
    justify-content: center; 
} 

.server-modal-overlay.active {
    display: flex;
} 

.server-modal {
    background: #fff;
    max-width: 500px;
    width: 94vw;
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
    padding: 30px;
    position: relative; 
    animation: fadeInUp 0.3s;
} 

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(60px);
    }
    to {
        opacity: 1;
        transform: none;
    } 
} 

.server-modal-close {
    position: absolute;
    top: 15px;
    right: 18px;
    font-size: 28px;
    background: rgba(100, 116, 139, 0.1);
    border: none;
    color: #64748b;
    cursor: pointer;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.server-modal-close:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    transform: rotate(90deg);
}

.server-modal h3 {
    font-size: 22px;
    font-weight: 800;
    color: #8b5cf6;
    margin: 0 0 20px 0;
}

.server-modal label {
    color: #0f172a;
    font-size: 14px; 
    font-weight: 700; 
    margin-top: 12px;
    margin-bottom: 6px;
    display: block;
}

.server-modal input, 
.server-modal textarea { 
    width: 100%;
    padding: 12px 14px; 
    margin-bottom: 12px;
    border: 2px solid #e2e8f0;
    border-radius: 10px; 
    resize: none; 
    font-size: 15px;
    transition: all 0.3s;
}

.server-modal input[type="file"] {
    border: 2px dashed #e2e8f0;
    padding: 20px;
    background: #f8fafc;
}

.server-modal input:focus,
.server-modal textarea:focus {
    outline: none;
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.server-modal .btn-modal {
    margin-top: 15px;
    width: 100%;
    padding: 14px 0;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
    color: #fff;
    font-weight: 800;
    font-size: 17px;
    letter-spacing: 0.5px; 
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
}

.server-modal .btn-modal:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
}

/* Page Title */
.page-title {
    margin: 35px 0 0 0;
    font-weight: 900;
    font-size: 32px;
    color: #0f172a;
    text-align: center;
}

@media (max-width: 768px) {
    .server-card-grid {
        grid-template-columns: 1fr;
    }
    
    .page-title {
        font-size: 26px;
    }
}
</style>

<h2 class="page-title">💻 Servicios Server / Tools Disponibles</h2>

<!-- Search Bar -->
<div class="search-bar-container">
    <div class="search-wrapper">
        <span class="search-icon">🔍</span>
        <input 
            type="text" 
            id="serviceSearch" 
            class="search-input" 
            placeholder="Buscar servicios de servidor, tools, activaciones..."
            autocomplete="off"
        >
        <button class="clear-search" id="clearSearch">×</button>
    </div>
    <div class="search-stats">
        Mostrando <span id="visibleCount">0</span> de <span id="totalCount">0</span> servicios
    </div>
  </div>
  
<!-- No Results Message -->
<div class="no-results" id="noResults">
    <div class="no-results-icon">🔍</div>
    <div class="no-results-text">No se encontraron servicios</div>
    <div class="no-results-subtext">Intenta con otros términos de búsqueda</div>
</div>

<!-- Services Grid -->
<?php if(!empty($services)): ?>
<div class="server-card-grid">
    <?php foreach($services as $service): ?>
    <div 
        class="server-card" 
        data-serviceid="<?php echo $service['ID']; ?>"
        data-title="<?php echo htmlspecialchars($service['Title']); ?>"
        data-price="<?php echo isset($service['Price']) ? $service['Price'] : ''; ?>"
        onclick='openServerModal(<?php echo json_encode($service["ID"]); ?>, <?php echo json_encode($service["Title"]); ?>, <?php echo json_encode(isset($service["Price"])?$service["Price"]:""); ?>)'
    >
        <div class="server-serv-title">💻 <?php echo htmlspecialchars($service['Title']); ?></div>
        <div class="server-serv-details">
            Servicio de servidor premium disponible
    </div>
        <div class="server-delivery">⏱ Tiempo: <?php echo isset($service['DeliveryTime']) && $service['DeliveryTime']!='' ? $service['DeliveryTime']:'Rápido'; ?></div>
        <div style="display:flex;align-items:center;margin-top:10px;gap:8px;flex-wrap:wrap;">
            <span class="server-price-chip">$<?php echo isset($service['Price'])?$service['Price']:'?'; ?></span>
            <span style="color:#64748b;font-size:13px;font-weight:700;">ID #<?php echo $service['ID'];?></span>
  </div>
  </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
<div style="padding:40px;text-align:center;color:#64748b;">
    <p style="font-size:18px;">📭 No hay servicios de servidor disponibles en este momento.</p>
    <p>Por favor, contacta al administrador.</p>
  </div>
<?php endif; ?>

<!-- MODAL -->
<div id="serverModalOverlay" class="server-modal-overlay" tabindex="-1">
    <div class="server-modal">
        <button class="server-modal-close" onclick="closeServerModal()">×</button>
        <h3 id="serverModalTitle">Servicio de Servidor</h3>
        <form method="post" action="<?php echo site_url('member/fileservices/insert'); ?>" enctype="multipart/form-data" id="serverForm">
            <input type="hidden" name="FileServiceID" id="ModalServiceID" required>
            
            <label for="ModalEmail">Email <span style="color:#dc2626;font-weight:700;">*</span></label>
            <input type="email" name="Email" id="ModalEmail" required placeholder="ejemplo@correo.com">
            
            <label for="ModalMobile">Teléfono (opcional)</label>
            <input type="text" name="Mobile" id="ModalMobile" placeholder="+1234567890">
            
            <label for="ModalNote">Nota (opcional)</label>
            <textarea name="Note" id="ModalNote" placeholder="Información adicional..." rows="2"></textarea>
            
            <label for="ModalFiles">Archivos <span style="color:#dc2626;font-weight:700;">*</span></label>
            <input type="file" name="File[]" id="ModalFiles" multiple required>
            <p style="font-size:12px;color:#64748b;margin-top:5px;">Puedes seleccionar múltiples archivos</p>
            
            <div id="extend"></div>
            
            <button type="submit" class="btn-modal">🚀 Solicitar Servicio</button>
        </form>
    </div>
</div>

<script>
// Modal Functions
function openServerModal(id, title, price) {
    document.getElementById('serverModalOverlay').classList.add('active');
    document.getElementById('ModalServiceID').value = id;
    document.getElementById('ModalEmail').value = '';
    document.getElementById('ModalMobile').value = '';
    document.getElementById('ModalNote').value = '';
    document.getElementById('ModalFiles').value = '';
    document.getElementById('serverModalTitle').textContent = title + (price ? ' - $'+price : '');
    
    // Load dynamic fields for this service
    loadServiceFields(id);
    
    setTimeout(function(){ document.getElementById('ModalEmail').focus(); }, 150);
}

function closeServerModal() { 
    document.getElementById('serverModalOverlay').classList.remove('active'); 
}

document.getElementById('serverModalOverlay').addEventListener('click', function(e) { 
    if(e.target === this) closeServerModal(); 
});

function loadServiceFields(serviceId) {
        $.ajax({
        type: "post",
            url: "<?php echo site_url('member/fileservices/filedata'); ?>",
        data: { FileServiceID: serviceId },
            cache: false,
        success: function(data) {
                $("#extend").html('');
                $("#extend").html(data);					
            }
        });				
    }    

// Search Functionality
(function() {
    const searchInput = document.getElementById('serviceSearch');
    const clearBtn = document.getElementById('clearSearch');
    const noResults = document.getElementById('noResults');
    const visibleCountEl = document.getElementById('visibleCount');
    const totalCountEl = document.getElementById('totalCount');
    
    const allCards = document.querySelectorAll('.server-card');
    const totalServices = allCards.length;
    
    totalCountEl.textContent = totalServices;
    visibleCountEl.textContent = totalServices;
    
    function updateSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        if(searchTerm) {
            clearBtn.style.display = 'flex';
        } else {
            clearBtn.style.display = 'none';
        }
        
        let visibleCount = 0;
        
        allCards.forEach(card => {
            const title = card.dataset.title.toLowerCase();
            const price = card.dataset.price.toLowerCase();
            
            const matches = title.includes(searchTerm) || price.includes(searchTerm);
            
            if(matches) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });
        
        if(visibleCount === 0 && searchTerm) {
            noResults.classList.add('active');
        } else {
            noResults.classList.remove('active');
        }
        
        visibleCountEl.textContent = visibleCount;
    }
    
    searchInput.addEventListener('input', updateSearch);
    
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        updateSearch();
        searchInput.focus();
    });
    
    document.addEventListener('keydown', function(e) {
        if((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }
        
        if(e.key === 'Escape' && document.activeElement === searchInput) {
            searchInput.value = '';
            updateSearch();
        }
    });
})();
</script>

</div>
</div>
