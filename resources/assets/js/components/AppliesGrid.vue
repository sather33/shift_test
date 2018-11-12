<template>
    <div class="row">
        <div class="col-lg-12">
            <form id="search">
                搜尋 <input name="query" v-model="query" @keyup="search(query)">
            </form>
            <!-- <div class="pull-right">
                {{ total }} Total Results
            </div> -->
            <section class="panel">
                <div class="panel-body">

                    <table class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <th></th>   
                            
                            <th v-for="key in gridColumns">
                                {{ key }}
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(row, index) in gridData">
                            <td>{{ index + 1}}</td>
                            <td>
                                {{ row.Name }}
                            </td>
                            <td>
                                {{ row.Email }}
                            </td>
                            <td>
                                {{ row.Gender }}
                            </td>
                            <td>
                                {{ row.Mobile }}
                            </td>
                            <td>
                                {{ row.BirthDate }}
                            </td>
                            <td>
                                {{ row.CitizenId }}
                            </td>
                            <td>
                                {{ row.AppliedTime }}
                            </td>
                            <td>
                                {{ row.上次編輯者 }}
                            </td>
                            <td>
                                {{ row.上次編輯時間 }}
                            </td>
                            <td >
                                <!-- <a v-bind:href="'/backend/activities/' + belongsToId + '/applies/' + row.Id +'/edit'">
                                    <button type="button" class="btn btn-default">
                                    編輯
                                    </button>
                                </a> -->
                                <button type="button" class="btn btn-default" data-toggle="modal" v-bind:data-target="'#editModal-' + row.Id">
                                查看/編輯
                                </button>
                                <!-- <div class="form-group">
                                    <form class="form" role="form" method="POST" v-bind:action="'/backend/visual/where-location' + row.Id">
                                        <input type="hidden" name="_method" value="delete">
                                        {{ csrf_field() }}
                                        <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete">
                                    </form>
                                </div> -->
                                <button class="btn btn-danger" @click.prevent="confirmDelete(row)">刪除</button>
                            </td>

                           <!-- Modal -->
                           <!-- <div  class="modal fade" v-bind:id="'editModal-' + row.Id" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <form v-bind:action="'/backend/activities/' + belongsToId + '/applies/' + row.Id" method="post" v-bind:id="'editModalForm-' + row.Id" v-on:submit.prevent="onUpdate">
                                        <input type="hidden" name="_method" value="patch">
                                        
                                        
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                        </div>

                                        <div class="modal-body">
                                            <div v-if="row.Name" class="form-group">
                                                <label for="name">姓名</label>
                                                <input type="text" class="form-control" id="name" name="name" v-bind:value="row.Name">
                                            </div>

                                            <div v-if="row.Gender" class="form-group">
                                                <label for="gender">性別</label>&nbsp;&nbsp;
                                                <label class="radio-inline">
                                                    <input type="radio" name="gender" id="gender-male" value="M" :checked="row.Gender == 'M'"> 男
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="gender" id="gender-female" value="F" :checked="row.Gender == 'F'"> 女
                                                </label>
                                            </div>

                                            <div v-if="row.BirthDate" class="form-group">
                                                <label for="birthdate">生日</label>
                                                <input type="text" class="form-control datepicker" id="birthdate" name="birthdate" v-bind:value="row.BirthDate">
                                            </div>

                                            <div v-if="row.CitizenId" class="form-group">
                                                <label for="citizen_id">身分證字號</label>
                                                <input type="text" class="form-control" id="citizen_id" name="citizen_id" v-bind:value="row.CitizenId">
                                            </div>

                                            <div v-if="row.Mobile" class="form-group">
                                                <label for="mobile">手機號碼</label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" v-bind:value="row.Mobile">
                                            </div>

                                            <div v-if="row.Email" class="form-group">
                                                <label for="email">E-Mail</label>
                                                <input type="email" class="form-control" id="email" name="email" v-bind:value="row.Email">
                                            </div>

                                            <div v-if="row.ClothSize" class="form-group">
                                                <label for="cloth_size">衣服尺寸</label>
                                                <select class="form-control" id="cloth_size" name="cloth_size">
                                                    <option value="1" :selected="row.ClothSize == '1'">1</option>
                                                    <option value="2" :selected="row.ClothSize == '2'">2</option>
                                                </select>
                                            </div>

                                            <div v-if="row.ShoeSize" class="form-group">
                                                <label for="shoe_size">鞋子尺寸</label>
                                                <select class="form-control" id="shoe_size" name="shoe_size">
                                                    <option value="1" :selected="row.ShoeSize == '1'">1</option>
                                                    <option value="2" :selected="row.ShoeSize == '2'">2</option>
                                                </select>
                                            </div>

                                            <div v-if="row.ICEName" class="form-group">
                                                <label for="ice_name">緊急聯絡人</label>
                                                <input type="text" class="form-control" id="ice_name" name="ice_name" v-bind:value="row.ICEName">
                                            </div>

                                            <div v-if="row.ICEPhone" class="form-group">
                                                <label for="ice_phone">緊急聯絡人電話</label>
                                                <input type="text" class="form-control" id="ice_phone" name="ice_phone" v-bind:value="row.ICEPhone">
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">取消/關閉</button>
                                            <button type="submit"  class="btn btn-primary">確認修改</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div> --> 
                        </tr>
                        </tbody>
                    </table>



                </div>

                <!-- <div class="pull-right">

                    page {{ current_page }} of   {{ last_page }} pages
                </div> -->

            </section>
            <!-- <div class="row">
                <div class="pull-right for-page-button">

                    <button @click="getData(go_to_page)"class="btn btn-default">
                        Go To Page:</button>
                    <input v-model="go_to_page" class="number-input"></input>

                </div>


                <ul class="pagination pull-right">
                    <li><a @click.prevent="getData(first_page_url)"> first </a></li>
                    <li v-if="checkUrlNotNull(prev_page_url)">
                        <a @click.prevent="getData(prev_page_url)" >prev</a>
                    </li>
                    <li v-for="page in pages"
                        v-if="page > current_page - 2 && page < current_page + 2"
                        v-bind:class="{'active': checkPage(page)}">
                        <a @click.prevent="getData(page)">{{ page }}</a>
                    </li>
                    <li v-if="checkUrlNotNull(next_page_url)">
                        <a @click.prevent="getData(next_page_url)">next</a>
                    </li>
                    <li><a @click.prevent="getData(last_page_url)"> last </a></li>
                </ul>
            </div> -->
        </div>
    </div>

    
    

</template>

<script>
    export default {
        mounted: function () {
            this.setBelongsToId();
            this.loadData();
        },
        data: function () {
            return {
                query: '',
                gridColumns: ['姓名', 'E-Mail', '性別', '手機號碼', '生日', '身分證字號', '報名時間', '上次編輯者', '上次編輯日期'],
                gridData: [],
                // total: null,
                // next_page_url: null,
                // prev_page_url: null,
                // last_page: null,
                // current_page: null,
                // pages: [],
                // first_page_url: null,
                // last_page_url: null,
                // go_to_page: null,
                sortOrder: 1,
                sortKey: '',
                belongsToId: 0,
            }
        },
        filters: {
        nl2br: function(value) {
                return (value + '')
                    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br/>' + '$2');
            }
        },
        computed: {
            form_method: function () {
                
                return this.$el.method.toLowerCase();
            },
            form_action: function () {
                return this.$el.action.toLowerCase();
            },
        },
        methods: {
            sortBy: function (key){
                this.sortKey = key;
                this.sortOrder = (this.sortOrder == 1) ? -1 : 1;
                this.getData(1);
            },
            search: function(query){
                this.getData(query);
            },
            loadData: function (){
                $.getJSON('/api/applies-data?belongs_to_id=' + this.belongsToId, function (data) {
                    this.gridData = data;
                    // this.total = data.total;
                    // this.last_page =  data.last_page;
                    // this.next_page_url = data.next_page_url;
                    // this.prev_page_url = data.prev_page_url;
                    // this.current_page = data.current_page;
                    // this.first_page_url = 'api/widget-data?page=1';
                    // this.last_page_url = 'api/widget-data?page=' + this.last_page;
                    // this.setPageNumbers();
                }.bind(this));
            },
            // setPageNumbers: function(){
            //     for (var i = 1; i <= this.last_page; i++) {
            //         this.pages.push(i);
            //     }
            // },
            getData: function (request){
                

                let getPage;
                switch (request){
                    // case this.prev_page_url :
                    //     getPage = this.prev_page_url +
                    //               '&column=' + this.sortKey +
                    //               '&direction=' + this.sortOrder;
                    //     break;
                    // case this.next_page_url :
                    //     getPage = this.next_page_url +
                    //               '&column=' + this.sortKey +
                    //               '&direction=' + this.sortOrder;
                    //     break;
                    // case this.first_page_url :
                    //     getPage = this.first_page_url +
                    //               '&column=' + this.sortKey +
                    //               '&direction=' + this.sortOrder;
                    //     break;
                    // case this.last_page_url :
                    //     getPage = this.last_page_url +
                    //               '&column=' + this.sortKey +
                    //               '&direction=' + this.sortOrder;
                    //     break;
                    case this.query :
                        getPage = '/api/applies-data?' +
                                  'keyword=' + this.query +
                                  '&column=' + this.sortKey +
                                  '&direction=' + this.sortOrder + 
                                  '&belongs_to_id=' + this.belongsToId;
                        break;
                    // case this.go_to_page :
                    //     if( this.go_to_page != '' && this.pageInRange()){
                    //         getPage = 'api/widget-data?' +
                    //                   'page=' + this.go_to_page +
                    //                   '&column=' + this.sortKey +
                    //                   '&direction=' + this.sortOrder +
                    //                   '&keyword=' + this.query;
                    //         this.clearPageNumberInputBox();
                    //     } else {
                    //         alert('Please enter a valid page number');
                    //     }
                    //     break;
                    default :
                        getPage = '/api/applies-data?' +
                                  // 'page=' + request +
                                  '&column=' + this.sortKey +
                                  '&direction=' + this.sortOrder +
                                  '&keyword=' + this.query + 
                                  '&belongs_to_id=' + this.belongsToId;
                        break;
                }
                if (this.query == '' && getPage != null){
                    $.getJSON(getPage, function (data) {
                        this.gridData = data;
                        // this.total = data.total;
                        // this.last_page =  data.last_page;
                        // this.next_page_url = data.next_page_url;
                        // this.prev_page_url = data.prev_page_url;
                        // this.current_page = data.current_page;
                    }.bind(this));
                } 
                else {
                    if (getPage != null){
                        $.getJSON(getPage, function (data) {
                            this.gridData = data;
                            // this.total = data.total;
                            // this.last_page =  data.last_page;
                            // this.next_page_url = (data.next_page_url == null) ? null : data.next_page_url + '&keyword=' +this.query;
                            // this.prev_page_url = (data.prev_page_url == null) ? null : data.prev_page_url + '&keyword=' +this.query;
                            // this.first_page_url = 'api/widget-data?page=1&keyword=' +this.query;
                            // this.last_page_url = 'api/widget-data?page=' + this.last_page + '&keyword=' +this.query;
                            // this.current_page = data.current_page;
                            // this.resetPageNumbers();
                        }.bind(this));
                    }
                }
            },
            // checkPage: function(page){
            //     return page == this.current_page;
            // },
            // resetPageNumbers: function(){
            //     this.pages = [];
            //     for (var i = 1; i <= this.last_page; i++) {
            //         this.pages.push(i);
            //     }
            // },
            checkUrlNotNull: function(url){
                return url != null;
            },
            // clearPageNumberInputBox: function(){
            //     return this.go_to_page = '';
            // },
            // pageInRange: function(){
            //     return this.go_to_page <= parseInt(this.last_page);
            // }
            setBelongsToId()
            {
                var pathArray = window.location.pathname.split( '/' );
                var id = pathArray[3];
                this.belongsToId = id
            },
            confirmDelete: function(item)
            {
                var vm = this;
                swal({
                    title: "確定刪除此報名表？",
                    text: "此為不可逆操作",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "取消",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "刪除",
                    closeOnConfirm: true
                },
                function(){
                    // swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    vm.deleteItem(item);
                });


                // var x = confirm("確定刪除此 activity?");
                // if (x)
                //     this.deleteItem(item);
                // else
                //     return false;
            },
            deleteItem: function(item){            
                this.$http.delete('/backend/activities/'+this.belongsToId+'/applies/'+item.Id).then((response) => {
                    // this.changePage(this.pagination.current_page);
                    // toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                    this.doSuccess("刪除報名表成功!");
                    this.getData();

                });
            },
            doSuccess(title) {
                swal("Congrats!", title, "success");
            },
            doError() {
                this.alertError();
            },
            doConfirm(item) {
                var vm = this;
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                },
                function(){
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    // return true;
                    // vm.deleteItem(item);
                });
            },
            datepicker() {
                
            },
            onUpdate:function (event) {
                let myForm = document.getElementById(event.target.id);
                let formData = new FormData(myForm);
                console.log(formData.entries());



                var formAction = event.target.action;
                // console.log(formAction);

                this.$http.patch(formAction, formData).then(this.successCallBack, this.errorCallBack);
            },
            // onSubmit: function (event) {
            //     // var formData = new FormData(this.$el);
            //     var formData = new FormData(this.$refs[refName]);
                



            //     // var formAction = event.target;
            //     // console.log(formAction);

            //     this.$http[this.form_method](this.form_action, formData)
            //             .then(this.successCallBack, this.errorCallBack);
            // },

            successCallBack: function (response) {
                console.log(response);
                console.log('AjaxForm submission: SUCCESS');
                this.doSuccess("更新報名表成功!");
                this.getData();
            },

            errorCallBack: function (response) {
                console.log('AjaxForm submission: ERROR');
            },
        }
    }
</script>