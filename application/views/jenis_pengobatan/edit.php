<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-info">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-info">
                            Edit Jenis Pengobatan
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('jenis_pengobatan') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <?= form_open('', [], ['id_jenis_pengobatan' => $jenis_pengobatan['id_jenis_pengobatan']]); ?>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="nama_jenis_pengobatan">Nama Asuransi</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('nama_jenis_pengobatan', $jenis_pengobatan['nama_jenis_pengobatan']); ?>" name="nama_jenis_pengobatan" id="nama_jenis_pengobatan" type="text" class="form-control" placeholder="Nama Asuransi">
                        <?= form_error('nama_jenis_pengobatan', '<small class="text-danger">', '</small>'); ?>
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