<template>
    <div class="row">
        <div class="col-lg-12">
            <form id="search">
                Search <input name="query" v-model="query" @keyup="search(query)">
            </form>
            <!-- <div class="pull-right">
                {{ total }} Total Results
            </div> -->
            <section class="panel">
                <div class="panel-body">

                    <table class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <th v-for="key in gridColumns"
                                @click="sortBy(key)"
                                v-bind:class="{active: sortKey == key}">
                                {{ key }}
                                <span class="arrow-small"
                                      v-bind:class="sortOrder > 0 ? 'asc' : 'dsc'">
                                </span>
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
                                {{ row.Mobile }}
                            </td>
                            <td>
                                {{ row.Email }}
                            </td>
                            <td>
                                <label v-bind:for="'vip_' + row.Id">
                                  <input type="checkbox" 
                                         v-bind:id="'vip_' + row.Id"
                                         v-bind:ref="'vip_' + row.Id"
                                         value="1"
                                         :checked="row.VIP == 1" 
                                         >
                                </label>
                            </td>
                            <td>
                                <label v-bind:for="'staff_' + row.Id">
                                  <input type="checkbox" 
                                         v-bind:id="'staff_' + row.Id"
                                         v-bind:ref="'staff_' + row.Id"
                                         value="1"
                                         :checked="row.Staff == 1" 
                                         >
                                </label>
                            </td>
                            <td>
                                <label v-bind:for="'admin_' + row.Id">
                                  <input type="checkbox" 
                                         v-bind:id="'admin_' + row.Id"
                                         v-bind:ref="'admin_' + row.Id"
                                         value="1"
                                         :checked="row.Admin == 1" 
                                         >
                                </label>
                            </td>
                            <td >

                                <button class="btn btn-success" @click.prevent="confirmUpdate(row)">更新</button>

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
                gridColumns: ['Name', 'Mobile', 'Email', 'VIP', 'Staff', 'Admin'],
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
                $.getJSON('/api/backend-users-data', function (data) {
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
                        getPage = '/api/backend-users-data?' +
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
                        getPage = '/api/backend-users-data?' +
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
            updateItem: function (item) {
                // console.log(this.$refs['vip_'+item.Id][0].checked);
                this.$http.patch('/backend/users/'+item.Id+'/update?is_vip='+this.$refs['vip_'+item.Id][0].checked+'&is_staff='+this.$refs['staff_'+item.Id][0].checked+'&is_admin='+this.$refs['admin_'+item.Id][0].checked ).then((response) => {
                    this.getData();
                });
            },
            confirmUpdate: function(item)
            {
                var x = confirm("確定更新此使用者權限?");
                if (x)
                    this.updateItem(item);
                else
                    return false;
            },
            deleteItem: function(item){
                this.$http.delete('/backend/users/'+item.Id).then((response) => {
                    // this.changePage(this.pagination.current_page);
                    // toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                    this.getData();
                });
            },
        }
    }
</script>