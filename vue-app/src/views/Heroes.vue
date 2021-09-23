<template>
    <div class="card text-center m-3" v-if='this.gotData == "yes"'>
        <h3 class="card-header">Superheroes!</h3>
        <div class="card-body">
            <div v-for="item in pageOfItems" :key="item.id">
                <div class="hero"> <router-link :to="{name: 'Hero', params: {nick_name: item.name}}">{{item.name}}</router-link></div>
                <div><img :src="item.image" alt="" style="width:150px;
   height:150px; max-height:50%"/></div>
   </div>
        </div>
        <div class="card-footer pb-0 pt-3">
            <jw-pagination :items="this.exampleItems" @changePage="onChangePage" :styles="customStyles" :pageSize="pagesize"></jw-pagination>
        </div>
    </div>
</template>

<script>
import api from '../api/api';

const customStyles = {

    li: {
        display: 'inline-block',
        border: '2px green'
    },
    a: {
        cursor: 'pointer',
        padding:'15px 20px',
        border: 'none',
        color: 'white',
        'border-radius': '6px',
        'background-color' : '#42b983'
    },


};



export default {
    data() {
        return {
            exampleItems: '',
            pageOfItems: [],
            customStyles,
            pagesize: 5,
            nick_names: [],
            images: [],
            gotData: '',
        
        };
    },
    methods: {
        onChangePage(pageOfItems) {
            this.pageOfItems = pageOfItems;
        },

        getHeroes() {
            api.get('/heroList')
            .then((response) => {
                console.log(response);
                
                for (let i = 0; i < response.data.length; i++) {
                    this.nick_names.push(response.data[i].nick_name);
                    this.images.push(response.data[i].image);

                    // if (this.images[i] == 'http://127.0.0.1:8000/images') {
                    //     this.images[i] = 'http://127.0.0.1:8000/images/6.png'
                    // }
                }
                 console.log(this.images[2]);
                
                this.gotData = "yes";
                this.exampleItems = [...Array(this.nick_names.length).keys()].map(i => ({ id: (i), name: (this.nick_names[i]), image: (this.images[i]) }));
                
            })
            .catch(error => console.log(error));
        }
    },
    created() {
        this.getHeroes();
    },
};
</script>

<style scoped>
img {
  border-radius: 50%;
}
.hero, a {
    color:#42b983;
    text-decoration: none;
    font-style: italic;
    font-size: 3vh;
}
</style>