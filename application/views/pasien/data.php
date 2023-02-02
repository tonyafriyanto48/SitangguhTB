<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-info">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-info">
                    Data Pasien
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('pasien/add') ?>" class="btn btn-sm btn-info btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah data Pasien
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID user</th>
                    <th>ID Pasien</th>
                    <th>Name</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>tanggal lahir</th>
                    <th>Asuransi</th>
                    <th>Jenis Pengobatan</th>
                    <th>klinik Pelapor</th>
                    <th>No tlpn</th>
                    <th>tanggal masuk</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($pasien) :
                    foreach ($pasien as $b) :
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $b['username']; ?></td>
                            <td><?= $b['id_pasien']; ?></td>
                            <td><?= $b['nama_pasien']; ?></td>
                            <td><?= $b['jenis_kelamin']; ?></td>
                            <td><?= $b['alamat']; ?></td>
                            <td><?= $b['tanggal_lahir']; ?></td>
                            <td><?= $b['nama_asuransi']; ?></td>
                            <td><?= $b['nama_jenis_pengobatan']; ?></td>
                            <td><?= $b['nama_klinik']; ?></td>
                            <td><?= $b['no_tlpn']; ?></td>
                            <td><?= $b['tanggal_masuk']; ?></td>
                            <!-- <td><?php echo '$' . number_format($b['no_tlpn']); ?></td> -->
                            <td>
                                <a href="<?= base_url('pasien/edit/') . $b['id_pasien'] ?>" class="btn btn-info btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('pasien/delete/') . $b['id_pasien'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="13" class="text-center">
                            Empty Data
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>