<template>
  <div>
    <h1>Nick Name of our superhero:</h1>
    <p style="font-size:4vh;">{{ this.$route.params.nick_name }}</p>
    <h3>The real name is</h3>
    <p>{{ this.real_name }}</p>
    <h3>What we know about this superhero:</h3>
    <p>{{ this.description }}</p>
    <h3>Our hero`s powers are:</h3>
    <p>{{ this.powers }}</p>
    <h3>And how people meet the hero:</h3>
    <p>{{ this.phrase }}</p>
    <div class="edit">
      <button type="button" @click.prevent="edit">Edit</button>
    </div>

    <ul>
      <li v-for="(image, index) in images" :key="image">
        <img :src="images[index]" alt="" style="width: 400px; height: 400px; max-height: 50%"/>
      </li>
    </ul>
  </div>
</template>

<script>

import api from '../api/api';


export default {
    name: "Hero",
    data() {
        return {
            real_name: '',
            description: '',
            powers: '',
            phrase: '',
            data: '',
            images: []
        }
    },
    created() {
        this.getImages();
    },
    mounted() {
         api.get('/getHeroByNick', {params: {nick_name: this.$route.params.nick_name}})
        .then(response => {
        this.real_name = response.data.real_name;
        this.description = response.data.description;
        this.powers = response.data.powers;
        this.phrase = response.data.phrase;
        console.log(response.data.phrase)
        })
        .catch(error => console.log(error));
        
    },

    methods: {
        edit() {
            this.$router.push({name: 'EditHero', params: {nick_name: this.$route.params.nick_name}})
        },
        getImages() {
            api.get('/getImages', {params: {nick_name: this.$route.params.nick_name}})
            .then((response) => {
                console.log('he',response.data[0]);
                for(let i = 0; i < response.data.length; i++) {
                    this.images[i] = response.data[i];
                }
            })
            .catch(error => console.log(error));
        },
    }
}
</script>

<style scoped>
h1,h3,h4 {
    color:#42b983;
}
p {
    font-style: italic;
    font-size: 2vh;
}
button {
  background-color: #42b983;
  color: white;
  padding: 26px 20px;
  /* margin: 30px 0; */
  font-size: 150%;
  border: none;
  cursor: pointer;
  opacity: 0.6;
  width:20%;
  border-radius: 6px;
}
button:hover {
  opacity: 1;
}
</style>