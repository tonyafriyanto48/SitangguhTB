<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-info">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-info">
                            Pasien Form
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('pasien') ?>" class="btn btn-sm btn-secondary btn-icon-split">
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
                <?= form_open(); ?>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="tanggal_masuk">tanggal Masuk</label>
                    <div class="col-md-4">
                        <input value="<?= set_value('tanggal_masuk', date('Y-m-d')); ?>" name="tanggal_masuk" id="tanggal_masuk" type="text" class="form-control date" placeholder="Tanggal Masuk...">
                        <?= form_error('tanggal_masuk', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="id_user">User</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="username" id="id_user" class="custom-select">
                                <option value="" selected disabled>Please Select..</option>
                                <?php foreach ($users as $user) : ?>
                                    <option <?= set_select('id_user', $user['id_user']) ?> value="<?= $user['username'] ?>"><?= $user['username'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?= form_error('id_user', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="id_pasien">ID Pasien</label>
                    <div class="col-md-9">
                        <input readonly value="<?= set_value('id_pasien', $id_pasien); ?>" name="id_pasien" id="id_pasien" type="text" class="form-control" placeholder="ID...">
                        <?= form_error('id_pasien', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="nama_pasien">Nama Pasien</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('nama_pasien'); ?>" name="nama_pasien" id="nama_pasien" type="text" class="form-control" placeholder="Masukan Nama ">
                        <?= form_error('nama_pasien', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="tanggal_lahir">Tanggal Lahir</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('tanggal_lahir'); ?>" name="tanggal_lahir" id="tanggal_lahir" type="date" class="form-control" placeholder="dd mm yyyy ">
                        <?= form_error('tanggal_lahir', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="jeniskelamin">Jenis kelamin </label>
                    <div class="col-md-6">
                        <div class="custom-control custom-radio">
                            <input <?= set_radio('jeniskelamin', 'Laki-laki'); ?> value="Laki-laki" type="radio" id="Laki-laki" name="jenis_kelamin" class="custom-control-input">
                            <label class="custom-control-label" for="Laki-laki">Laki-laki</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input <?= set_radio('jeniskelamin', 'Perempuan'); ?> value="Perempuan" type="radio" id="Perempuan" name="jenis_kelamin" class="custom-control-input">
                            <label class="custom-control-label" for="Perempuan">Perempuan</label>
                        </div>
                        <?= form_error('jeniskelamin', '<span class="text-danger small">', '</span>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="alamat">Alamat</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-fw fa-location-arrow"></i></span>
                            </div>
                            <textarea name="alamat" id="alamat" class="form-control" rows="4" placeholder="Full Address"><?= set_value('alamat'); ?></textarea>
                        </div>
                        <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="jenis_pengobatan_id">Jenis Pengobatan</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="nama_jenis_pengobatan" id="jenis_pengobatan_id" class="custom-select">
                                <option value="" selected disabled>Please Select..</option>
                                <?php foreach ($jenis_pengobatan as $j) : ?>
                                    <option <?= set_select('jenis_pengobatan_id', $j['id_jenis_pengobatan']) ?> value="<?= $j['nama_jenis_pengobatan'] ?>"><?= $j['nama_jenis_pengobatan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-info" href="<?= base_url('jenis_pengobatan/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('jenis_pengobatan_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="asuransi_id">Asuransi</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="nama_asuransi" id="asuransi_id" class="custom-select">
                                <option value="" selected disabled>Please Select..</option>
                                <?php foreach ($asuransi as $s) : ?>
                                    <option <?= set_select('asuransi_id', $s['id_asuransi']) ?> value="<?= $s['nama_asuransi'] ?>"><?= $s['nama_asuransi'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-info" href="<?= base_url('asuransi/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('id_asuransi', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="klinik_id">Klinik Pengobatan</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="nama_klinik" id="klinik_id" class="custom-select">
                                <option value="" selected disabled>Please Select..</option>
                                <?php foreach ($klinik as $sp) : ?>
                                    <option <?= set_select('klinik_id', $sp['id_klinik']) ?> value="<?= $sp['nama_klinik'] ?>"><?= $sp['nama_klinik'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-info" href="<?= base_url('klinik/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('id_klinik', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-3 text-md-right" for="no_tlpn">No Telpon</label>
                    <div class="col-md-9">
                        <input value="<?= set_value('no_tlpn'); ?>" name="no_tlpn" id="no_tlpn" type="text" class="form-control" placeholder="08...">
                        <?= form_error('no_tlpn', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="reset" class="btn btn-danger">Reset</bu>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>