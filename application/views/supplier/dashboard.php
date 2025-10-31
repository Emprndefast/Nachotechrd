<div class="workplace">

                <div class="row-fluid">
                    <div class="span12">

                        <div class="widgetButtons">                        
                            <div class="bb"><a href="#" class="tipb" title="Edit"><span class="ibw-edit"></span></a></div>
                            <div class="bb">
                                <a href="#" class="tipb" title="Upload"><span class="ibw-folder"></span></a>
                                <div class="caption red">31</div>
                            </div>
                            <div class="bb"><a href="#" class="tipb" title="Add new"><span class="ibw-plus"></span></a></div>
                            <div class="bb"><a href="#" class="tipb" title="Add to favorite"><span class="ibw-favorite"></span></a></div>
                            <div class="bb">
                                <a href="#" class="tipb" title="Send mail"><span class="ibw-mail"></span></a>
                                <div class="caption green">31</div>
                            </div>
                            <div class="bb"><a href="<?php echo site_url('admin/configuration'); ?>" class="tipb" title="Settings"><span class="ibw-settings"></span></a></div>
                        </div>

                    </div>
                </div>

                <div class="row-fluid">

                    <div class="span4">                    

                        <div class="wBlock red clearfix">                        
                            <div class="dSpace">
                                <h3>Invoices statistics</h3>
                                <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--130,190,260,230,290,400,340,360,390--></span>
                                <span class="number">60%</span>                    
                            </div>
                            <div class="rSpace">
                                <span>$1,530 <b>amount paid</b></span>
                                <span>$2,102 <b>in queue</b></span>
                                <span>$11,100 <b>total taxes</b></span>
                            </div>                          
                        </div>                     

                    </div>                

                    <div class="span4">                    

                        <div class="wBlock green clearfix">                        
                            <div class="dSpace">
                                <h3>Users</h3>
                                <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--5,10,15,20,23,21,25,20,15,10,25,20,10--></span>
                                <span class="number">2,513</span>                    
                            </div>
                            <div class="rSpace">
                                <span>351 <b>active</b></span>
                                <span>2102 <b>passive</b></span>
                                <span>100 <b>removed</b></span>
                            </div>                          
                        </div>                                                            

                    </div>

                    <div class="span4">                    

                        <div class="wBlock blue clearfix">
                            <div class="dSpace">
                                <h3>Last visits</h3>
                                <span class="mChartBar" sparkType="bar" sparkBarColor="white"><!--240,234,150,290,310,240,210,400,320,198,250,222,111,240,221,340,250,190--></span>
                                <span class="number">6,302</span>                    
                            </div>
                            <div class="rSpace">                                                                           
                                <span>65% <b>New</b></span>
                                <span>35% <b>Returning</b></span>
                                <span>00:05:12 <b>Average time on site</b></span>                                                        
                            </div>
                        </div>                      

                    </div>                
                </div>            

                <div class="dr"><span></span></div>
                 <div class="row-fluid">

                    <div class="span12">                    
                        <div class="head clearfix">
                            <div class="isw-grid"></div>
                            <h1>Productos/Servicios Asignados</h1>      
                                           
                        </div>
                        <div class="block-fluid">
                            <?php if(!empty($networks)): ?>
                            <table cellpadding="0" cellspacing="0" width="100%" class="table">
                                <thead>
                                    <tr>                                    
                                        <th width="30%">Nombre del Servicio</th>
                                        <th width="15%">Precio</th>
                                        <th width="20%">Tiempo de Entrega</th>
                                        <th width="15%">Estado</th>
                                        <th width="20%">Descripción</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php foreach($networks as $network): ?>
                                    <tr>                                    
                                        <td><?php echo htmlspecialchars($network['Title']); ?></td>
                                        <td>$<?php echo number_format($network['Price'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($network['DeliveryTime']); ?></td>
                                        <td>
                                        	<span class="label label-<?php echo $network['Status'] == 'Enabled' ? 'success' : 'danger'; ?>">
                                        		<?php echo $network['Status'] == 'Enabled' ? 'Activo' : 'Inactivo'; ?>
                                        	</span>
                                        </td>
                                        <td><?php echo htmlspecialchars(substr($network['Description'], 0, 50)); ?><?php echo strlen($network['Description']) > 50 ? '...' : ''; ?></td>                                    
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <div class="alert alert-info">
                            	<strong>No hay productos asignados.</strong> Contacta al administrador para que te asignen servicios.
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>                                

                </div>            

                <div class="dr"><span></span></div>
            </div>
