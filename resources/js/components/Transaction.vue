<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Transaction List</h3>

                <div class="card-tools">
                  
                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Company Name</th>
                      <th>Paid?</th>
                      <th>Products</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="transaction in transactions.data" :key="transaction.id">

                      <td>{{transaction.id}}</td>
                      <td>{{transaction.company.name}}</td>
                      <td>{{transaction.is_paid ? 'Yes':'No'}}</td>
                          <span  v-for="prod in transaction.products" :key="prod.id">
                            <td>{{prod.name}},</td>
                          </span>
                      <td>
                        
                        <a href="#" @click="editModal(transaction)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteProduct(transaction.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="transactions" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Transaction</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form @submit.prevent="editmode ? updateProduct() : createTransaction()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Companies</label>
                            <select class="form-control" v-model="form.company_id" required>
                            <option value="">Select Company</option>
                              <option 
                                  v-for="(cat,index) in companies" :key="index"
                                  :value="index"
                                  :selected="index == form.category_id">{{ cat }}
                                  </option>
                            </select>
                            <has-error :form="form" field="company_id"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Products</label>
                            <div>Selected : {{ checkedNames }}</div> <br>
                            <div class="form-control" v-for="(prod,index) in products" :key="index">
                              <input name="product_ids" type="checkbox" :id="prod" :value="prod" v-model="form.product_ids">
                              <label :for="prod">{{prod}}</label>
                            </div>
                            <has-error :form="form" field="product_ids"></has-error>
                        </div>
                      
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';
    export default {
      components: {
          VueTagsInput,
        },
        data () {
            return {
              checkedNames:[],
                editmode: false,
                transactions : {},
                form: new Form({
                    company_id : '',
                    is_paid : false,
                    product_ids:  [],
                }),
                companies: [],
                products: [],
              
                tag:  '',
                autocompleteItems: [],
            }
        },
        methods: {
          getResults(page = 1) {
              this.$Progress.start();
              
              axios.get('api/product?page=' + page).then(({ data }) => (this.products = data.data));
              this.$Progress.finish();
          },
          loadTransactions(){
            // if(this.$gate.isAdmin()){
              axios.get("api/transaction").then(({ data }) => {
                this.transactions = data.data,
                console.log(this.transactions)
                
          });
          },
            loadCompanies(){
              axios.get("/api/company/list").then(({ data }) => {this.companies = data.data
              console.log(this.companies)
              });
          },
         
          loadProducts(){

              axios.get("/api/product/list").then(({ data }) => {this.products = data.data
              console.log('prod',this.products)
              });
          },
          editModal(product){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(product);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createTransaction(){
              this.$Progress.start();
              this.form.post('api/transaction')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');
                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadTransactions();
                } else {
                  console.log(data),
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
                  this.$Progress.fail();
                }
              })
              .catch(()=>{
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },
          updateProduct(){
              this.$Progress.start();
              this.form.put('api/product/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');
                  this.loadTransactions();
              })
              .catch(() => {
                  this.$Progress.fail();
              });
          },
          deleteProduct(id){
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/transaction/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadTransactions();
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
            this.loadTransactions();
           this.loadCompanies();
           this.loadProducts();
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