<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-info">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-info">
                            Edit Asuransi
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('asuransi') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Back
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open('', [], ['id_asuransi' => $asuransi['id_asuransi']]); ?>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="nama_asuransi">Nama Asuransi</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('nama_asuransi', $asuransi['nama_asuransi']); ?>" name="nama_asuransi" id="nama_asuransi" type="text" class="form-control" placeholder="Nama Asuransi">
                        <?= form_error('nama_asuransi', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-info">Make Changes</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>