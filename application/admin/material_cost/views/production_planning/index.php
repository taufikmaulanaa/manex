<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
            <label class=""><?php echo lang('tahun'); ?> &nbsp</label>
			<select class="select2 infinity custom-select" style="width: 80px;" id="filter_tahun">
				<?php foreach ($tahun as $tahun) { ?>
					<option value="<?php echo $tahun->tahun; ?>" <?php if ($tahun->tahun == user('tahun_budget')) echo ' selected'; ?>><?php echo $tahun->tahun; ?></option>
				<?php } ?>
			</select>

			<label class=""><?php echo lang('factory'); ?>  &nbsp</label>
			<select class="select2 infinity custom-select" style="width: 180px;" id="filter_cost_centre">
				<option value="ALL">ALL FACTORY</option>
				<?php foreach ($cc as $c) { ?>
                <option value="<?php echo $c->kode; ?>"><?php echo $c->cost_centre; ?></option>
                <?php } ?>
			</select>

			<?php  

			echo '<button class="btn btn-info btn-proses" href="javascript:;" ><i class="fa-process"></i> Running MRP</button>';
            echo '<button class="btn btn-success btn-save" href="javascript:;" > Save <span class="fa-save"></span></button>';

            $arr = [];
                $arr = [
                    // ['btn-save','Save Data','fa-save'],
                    ['btn-export','Export Data','fa-upload'],
                    ['btn-import','Import Data Begining Stock','fa-download'],
                    ['btn-template','Template Import','fa-reg-file-alt']
                ];
            
            
            echo access_button('',$arr); 

                        
            ?>
	
        </div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="content-body mt-6">
	<div class="main-container mt-2">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
	    			<div class="card-header"><?= $title ?></div>
	    			<div class="card-body">
	    				<div class="table-responsive tab-pane fade active show height-window">
	    				<?php
						table_open('table table-bordered table-app table-hover table-1');
							thead();
								tr();
									th('Revisi ke : ','','width="60" class="text-left"');
                                    th(lang('standar'),'','width="60" colspan="4" class="text-left"');
									for ($i = 1; $i <= 12; $i++) { 
										th('','','class="text-center" style="min-width:80px"');		
									}
									th(lang('total'),'','width="60" rowspan="2" class="text-center align-middle headcol"');

                                    tr();
									th(lang('description'),'','width="60" rowspan="2" class="text-center align-middle headcol"');
									th(lang('code'),'','width="60" rowspan="2" class="text-center align-middle headcol"');
									th(lang('dest'),'','width="60" rowspan="2" class="text-center align-middle headcol"');
                                    th(lang('batch'),'','width="60" rowspan="2" class="text-center align-middle headcol"');
                                    th(lang(''),'','width="60" rowspan="2" class="text-center align-middle headcol"');
									for ($i = 1; $i <= 12; $i++) { 
										th(month_lang($i),'','class="text-center" style="min-width:80px"');		
									}
			             
							
							tbody();
						table_close();
						?>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	</div>
</div>

<script>
	$(document).ready(function() {
		getData();
		$(document).on('keyup', '.budget', function(e) {
		});

	});

	$('#filter_tahun').change(function() {
		getData()
	});

	$('#filter_cost_centre').change(function() {
		getData()
	});

    function getData() {
        cLoader.open(lang.memuat_data + '...');
        $('.overlay-wrap').removeClass('hidden');
        var page = base_url + 'material_cost/production_planning/data';
            page 	+= '/'+$('#filter_tahun').val();
			page 	+= '/'+$('#filter_cost_centre').val();

        $.ajax({
            url 	: page,
            data 	: {},
            type	: 'get',
            dataType: 'json',
            success	: function(response) {
                $('.table-1 tbody').html(response.table);
                cLoader.close();
                $('.overlay-wrap').addClass('hidden');	
            }
        });
    }    

	var id_proses = '';
	var tahun = 0;
	$(document).on('click','.btn-proses',function(e){
		e.preventDefault();
		id_proses = 'proses';
		tahun = $('#filter_tahun').val();
		factory = $('#filter_cost_centre').val();
		cConfirm.open(lang.apakah_anda_yakin + '?','lanjut');
	});

	function lanjut() {
		$.ajax({
			url : base_url + 'material_cost/production_planning/proses',
			data : {id:id_proses,tahun : tahun, factory : factory},
			type : 'post',
			dataType : 'json',
			success : function(res) {
				cAlert.open(res.message,res.status,'refreshData');
			}
		});
	}

	$(document).on('click','.btn-save',function(){
	var i = 0;
	$('.edited').each(function(){
		i++;
	});
	if(i == 0) {
		cAlert.open('tidak ada data yang di ubah');
	} else {
		var msg 	= lang.anda_yakin_menyetujui;
		if( i == 0) msg = lang.anda_yakin_menolak;
		cConfirm.open(msg,'save_perubahan');        
	}

});

function save_perubahan() {
	var data_edit = {};
	var i = 0;
	
	$('.edited').each(function(){
		var content = $(this).children('div');
		if(typeof data_edit[$(this).attr('data-id')] == 'undefined') {
			data_edit[$(this).attr('data-id')] = {};
		}
		data_edit[$(this).attr('data-id')][$(this).attr('data-name')] = $(this).text().replace(/[^0-9\-]/g,'');
		i++;
	});
	
	var jsonString = JSON.stringify(data_edit);		
	$.ajax({
		url : base_url + 'material_cost/production_planning/save_perubahan',
		data 	: {
			'json' : jsonString,
			verifikasi : i,
			tahun : $('#tahun').val(),
		},
		type : 'post',
		success : function(response) {
			cAlert.open(response,'success','refreshData');
		}
	})
}
</script>