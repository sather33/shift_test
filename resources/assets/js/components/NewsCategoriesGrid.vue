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
                            <th v-for="key in gridColumns">
                                {{ key }}
                            </th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in gridData">
                            <td>
                                {{ row.Name }}
                            </td>
                            <td>
                                {{ row.Order }}
                            </td>
                            <td>
                                {{ row.Status }}
                            </td>
                            <td>
                                {{ row.上次編輯者 }}
                            </td>
                            <td>
                                {{ row.上次編輯時間 }}
                            </td>
                            <td >
                                <a v-bind:href="'/backend/news-categories/' + row.Id + '/edit'">
                                    <button type="button" class="btn btn-default">
                                    編輯
                                    </button>
                                </a>
                                <!-- <div class="form-group">
                                    <form class="form" role="form" method="POST" v-bind:action="'/backend/visual/where-location' + row.Id">
                                        <input type="hidden" name="_method" value="delete">
                                        {{ csrf_field() }}
                                        <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete">
                                    </form>
                                </div> -->
                                <button v-if="row.Deleteable" class="btn btn-danger" @click.prevent="confirmDelete(row)">刪除</button>
                            </td>
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
            this.loadData();
        },
        data: function () {
            return {
                query: '',
                gridColumns: ['分類名稱', '排序', '狀態', '上次編輯者', '上次編輯日期'],
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
                sortKey: ''
            }
        },
        filters: {
        nl2br: function(value) {
                return (value + '')
                    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br/>' + '$2');
            }
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
                $.getJSON('/api/news-categories-data', function (data) {
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
                        getPage = '/api/news-categories-data?' +
                                  'keyword=' + this.query +
                                  '&column=' + this.sortKey +
                                  '&direction=' + this.sortOrder;
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
                        getPage = '/api/news-categories-data?' +
                                  // 'page=' + request +
                                  '&column=' + this.sortKey +
                                  '&direction=' + this.sortOrder +
                                  '&keyword=' + this.query;
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
            confirmDelete: function(item)
            {
                var vm = this;
                swal({
                    title: "確定刪除此品牌分類？",
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


                // var x = confirm("確定刪除此 Banner?");
                // if (x)
                //     this.deleteItem(item);
                // else
                //     return false;
            },
            deleteItem: function(item){
                this.$http.delete('/backend/news-categories/'+item.Id).then((response) => {
                    // this.changePage(this.pagination.current_page);
                    // toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                    this.doSuccess("刪除最新消息分類成功!");
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
            }
        }
    }
</script>