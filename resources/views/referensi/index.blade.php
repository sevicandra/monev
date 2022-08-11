


@extends('layout.main')

@section('content')
<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Referensi</h1>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @canany(['Staf_KPA', 'KPA'], auth()->user()->id)
                            <tr>
                                <td>1</td>
                                <td>Pagu</td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="pagu" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                    </div>
                                </td>
                            </tr>
                        @endcanany
                        
                        @can('admin_satker', auth()->user()->id)
                            <tr>
                                <td>2</td>
                                <td>Unit</td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                    </div>
                                </td>
                            </tr>
                        @endcan


                        @can('sys_admin', auth()->user()->id)


                            <tr>
                                <td>4</td>
                                <td>Satuan Kerja</td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="satker" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Jenis Dokumen</td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Tahun Anggaran</td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Berkas</td>
                                <td class="pb-0 pr-0">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                    </div>
                                </td>
                            </tr>
                        @endcan
                        @can('sys_admin', auth()->user()->id)
                        <tr>
                            <td>8</td>
                            <td>PPH</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                </div>
                            </td>
                        </tr>
                        @endcan
                        
                        @can('admin_satker', auth()->user()->id)
                        <tr>
                            <td>9</td>
                            <td>Pejabat</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                </div>
                            </td>
                        </tr>
                        @endcan    
                        @canany(['PPK', 'Staf_PPK'], auth()->user()->id)
                        <tr>
                            <td>10</td>
                            <td>Pegawai Non DJKN</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                </div>
                            </td>
                        </tr>
                        @endcanany

                        @can('sys_admin', auth()->user()->id)
                        <tr>
                            <td>11</td>
                            <td>Bulan</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                </div>
                            </td>
                        </tr>
                        @endcan
                        @can('admin_satker', auth()->user()->id)
                        <tr>
                            <td>12</td>
                            <td>Nomor</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                </div>
                            </td>
                        </tr>
                        @endcan
                        @can('sys_admin', auth()->user()->id)
                        <tr>
                            <td>13</td>
                            <td>Users</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="user" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Role</td>
                            <td class="pb-0 pr-0">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="role" class="btn btn-sm btn-outline-secondary pt-0 pb-0">Detail</a>
                                </div>
                            </td>
                        </tr>
                        @endcan
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection