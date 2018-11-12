<!--first example-->
<!-- <template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template> -->

<!--<script>
    export default {
        ready() {
            console.log('Component ready.')
        }
    }
</script>-->


<!--second example for function call-->
<!--
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div id="name-form">
                        <label for="name">Enter name:</label>
                        <input type="text" v-model="name" id="name" name="name" />
                        <p>{{ name }}</p>
                        <button @click="clearData()"class="btn btn-default">
                            Clear</button> added a button to call clear function 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var givenName = 'Bill'; // variable for functon

    export default {
        data : function(){
            return {
                name: ''
            }
        },
        methods : { // add methods
            loadData : function(){
               this.name = givenName;
            },
            clearData : function(){
                this.name ='';
            }
        },
        ready() {
            this.loadData(); // call method.
            console.log('Component ready.')
        }
    }
</script>
-->

<!--third example for v-for-->

<template>
    <!-- <div class="container"> -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">List the Beatles</div>
                    <div>
                        <ul>
                            <li v-for="member in beatles">{{member}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
</template>

<script>
    var bandMembers =['John', 'Paul', 'George', 'Ringo'];
    export default {
        data : function(){
            return {
                beatles: []
            }
        },
        methods : {
            loadData : function(){
                this.beatles = bandMembers;
            }
        },
        mounted() {
            this.loadData();
            console.log('Component ready.')
        }
    }
</script>