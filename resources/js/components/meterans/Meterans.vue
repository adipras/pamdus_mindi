<template>
  <section class="content">
    <div class="container-fluid">
        <form action="" class="row">
            <div class="col-4">
                <div class="form-group">
                    <label>Tahun</label>
                    <select class="form-control" v-model="tahun">
                        <option v-for="(year,index) in years" :key="index" :value="year">{{year}}</option>
                    </select>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label>Bulan</label>
                    <select class="form-control" v-model="bulan">
                        <option v-for="(month,index) in months" :key="index" :value="month">{{month}}</option>
                    </select>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label>Pelanggan</label>
                    <select class="form-control" v-model="pelanggan">
                        <option v-for="(user,index) in pelanggans.data" :key="index" :value="user.id">{{user.nik}} - {{ user.nama }}</option>
                    </select>
                </div>
            </div>

            <div class="col-3">
                <button class="btn btn-info text-white" type="button" @click="cari">Cari</button>
            </div>
        </form>
        <hr/>
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Meteran</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-outline-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Tambah
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th rowspan="2" class="text-center">No meteran</th>
                      <th rowspan="2" class="text-center">NIK KTP</th>
                      <th rowspan="2" class="text-center">Nama</th>
                      <th rowspan="2" class="text-center">Tahun</th>
                      <th rowspan="2" class="text-center">Bulan</th>
                      <th colspan="2" class="text-center">Stand Meter (M3)</th>
                      <th rowspan="2" class="text-center">Pemakaian</th>
                      <th rowspan="2" class="text-center">Status</th>
                      <th rowspan="2" class="text-center">Action</th>
                    </tr>
                    <tr>
                        <th class="text-center">Bulan Ini</th>
                        <th class="text-center">Bulan Lalu</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(meteran,index) in meterans.data" :key="index">
                          <td>{{meteran.no_meteran}}</td>
                          <td>{{meteran.nik}}</td>
                          <td>{{meteran.nama}}</td>
                          <td>{{meteran.periode}}</td>
                          <td>{{meteran.bulan}}</td>
                          <td>{{meteran.awal}}</td>
                          <td>{{meteran.akhir}}</td>
                          <td>{{meteran.pemakaian}}</td>
                          <td>Belum Bayar</td>
                          <td class="text-center">
                            <a href="#" @click="showHistory(pelanggan)" class="btn btn-sm btn-outline-info">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#" @click="editModal(pelanggan)" class="btn btn-sm btn-outline-success">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="#" @click="deletePelanggan(pelanggan)" class="btn btn-sm btn-outline-danger">
                                <i class="fa fa-trash"></i>
                            </a>
                           </td>
                      </tr>    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="meterans" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal Create/Update -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Tambah Pelanggan</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateMeteran() : createMeteran()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pelanggan</label>
                            <select class="form-control" v-model="form.pelanggan_id">
                                <option v-for="(user,index) in pelanggans.data" :key="index" :value="user.id">{{user.nik}} - {{ user.nama }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-control" v-model="form.periode">
                                <option v-for="(year,index) in years" :key="index" :value="year">{{year}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bulan</label>
                            <select class="form-control" v-model="form.bulan">
                                <option v-for="(month,index) in months" :key="index" :value="month">{{month}}</option>
                            </select>
                        </div>

                        <h3>Stand Meter (M3)</h3>
                        <div class="form-group">
                            <label>Bulan Ini</label>
                            <input type="text" class="form-control" v-model="form.akhir">
                        </div>
                        <div class="form-group">
                            <label>Bulan Lalu</label>
                            <input type="text" class="form-control" v-model="form.awal">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Simpan</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>

    export default {
        components: {
        },
        data () {
            return {
                months:['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                editmode: false,
                bulan:null,
                tahun:null,
                pelanggan:1,
                pelanggans : {},
                meterans : {},
                form: new Form({
                    pelanggan_id : 1,
                    periode : new Date().getFullYear(),
                    bulan : 'Februari',
                    awal: 0,
                    akhir: 0,
                }),
            }
        },
        methods: {

            cari(){
                this.$Progress.start();

                this.loadMeterans(this.tahun,this.bulan,this.pelanggan);

                this.$Progress.finish();
            },

          getResults(page = 1) {

              this.$Progress.start();

              axios.get('api/meteran?page=' + page).then(({ data }) => (this.meterans = data.data));

              this.$Progress.finish();
          },
          loadMeterans(tahun,bulan,pelanggan){

            // if(this.$gate.isAdmin()){
              axios.get("api/meteran?pelanggan="+pelanggan+"&tahun="+tahun+"&bulan="+bulan).then(({ data }) => (this.meterans = data.data));
            // }
          },
          loadPelanggans(){

            // if(this.$gate.isAdmin()){
              axios.get("api/pelanggan").then(({ data }) => (this.pelanggans = data.data));
            // }
          },
          showHistory(meteran){
              $('#showDetail').modal('show');
              this.form.fill(meteran);
          },
          editModal(meteran){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(meteran);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createMeteran(){
              this.$Progress.start();

              console.log(this.form);

              this.form.post('api/meteran')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadMeterans();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });

                  this.$Progress.failed();
                }
              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },
          updateMeteran(){
              this.$Progress.start();
              this.form.put('api/meteran/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadMeterans();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteMeteran(meteran){
              Swal.fire({
                  title: 'Apakah anda yakin?',
                  text: "menghapus data meteran atas nama '"+meteran.nama+"'",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Ya, hapus data ini!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/meteran/'+pelanggan.id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your data has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadMeterans();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },

        },
        mounted() {

        },
        created() {
            this.$Progress.start();

            
            this.loadPelanggans();
            this.tahun = new Date().getFullYear();
            this.bulan = this.months[new Date().getMonth()];

            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
          years () {
            const year = new Date().getFullYear()
            return Array.from({length: year - 2021}, (value, index) => 2022 + index)
          }
        },
    }
</script>

<style>

</style>
