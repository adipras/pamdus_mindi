<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Pelanggan</h3>

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
                      <th class="text-center">No meteran</th>
                      <th class="text-center">Nama</th>
                      <th class="text-center">NIK KTP</th>
                      <th class="text-center">Alamat</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="pelanggan in pelanggans.data" :key="pelanggan.id">

                      <td>{{pelanggan.no_meteran}}</td>
                      <td>{{pelanggan.nama}}</td>
                      <td>{{pelanggan.nik}}</td>
                      <td>{{pelanggan.address | truncate(30, '...')}}</td>
                      <td>{{ handleStatus(pelanggan.is_active)}}</td>
                      <!-- <td><img v-bind:src="'/' + product.photo" width="100" alt="product"></td> -->
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
                  <pagination :data="pelanggans" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal Show Detail -->
        <div class="modal fade" id="showDetail" tabindex="-1" role="dialog" aria-labelledby="showDetail" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Riwayat Tagihan Pelanggan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        This is a modal-body
                    </div>
                </div>
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

                <form @submit.prevent="editmode ? updatePelanggan() : createPelanggan()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>No Meteran</label>
                            <input v-model="form.no_meteran" type="text" name="no_meteran"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_meteran') }">
                            <has-error :form="form" field="no_meteran"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input v-model="form.nama" type="text" name="nama"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('nama') }">
                            <has-error :form="form" field="nama"></has-error>
                        </div>
                        <div class="form-group">
                            <label>NIK KTP</label>
                            <input v-model="form.nik" type="text" name="nik"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('nik') }">
                            <has-error :form="form" field="nik"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input v-model="form.address" type="text" name="address"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                            <has-error :form="form" field="address"></has-error>
                        </div>
                        <div v-show="editmode" class="form-group">
                            <label>Status</label>
                            <input v-model="form.is_active" type="checkbox" name="is_active"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('is_active') }">
                            <div><strong>{{ form.is_active  ? 'Aktif' : 'Tidak AKtif' }}</strong></div>
                            <has-error :form="form" field="is_active"></has-error>
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
                editmode: false,
                pelanggans : {},
                form: new Form({
                    id : '',
                    no_meteran : '',
                    nama: '',
                    nik: '',
                    address: '',
                    is_active: '',
                }),
            }
        },
        methods: {
          handleStatus(status) {
              return status ? 'Aktif' : 'Tidak Aktif';
          },

          getResults(page = 1) {

              this.$Progress.start();

              axios.get('api/pelanggan?page=' + page).then(({ data }) => (this.pelanggans = data.data));

              this.$Progress.finish();
          },
          loadPelanggans(){

            // if(this.$gate.isAdmin()){
              axios.get("api/pelanggan").then(({ data }) => (this.pelanggans = data.data));
            // }
          },
          showHistory(pelanggan){
              $('#showDetail').modal('show');
              this.form.fill(pelanggan);
          },
          editModal(pelanggan){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(pelanggan);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createPelanggan(){
              this.$Progress.start();

              this.form.post('api/pelanggan')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadPelanggans();

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
          updatePelanggan(){
              this.$Progress.start();
              this.form.put('api/pelanggan/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadPelanggans();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deletePelanggan(pelanggan){
              Swal.fire({
                  title: 'Apakah anda yakin?',
                  text: "menghapus data pelanggan atas nama '"+pelanggan.nama+"'",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Ya, hapus data ini!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/pelanggan/'+pelanggan.id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your data has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadPelanggans();
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
        },
    }
</script>

<style>

</style>
