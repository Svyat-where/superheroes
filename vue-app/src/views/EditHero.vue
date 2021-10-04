<template>
  <div class="container">
    <form>
      <label for="">Nick Name:</label>

      <input type="text" name="" id="" value="" v-model="form.nick_name" />

      <label for="">Real Name: </label>

      <input type="text" name="" id="" value="" v-model="form.real_name" />

      <label for="">Description:</label>

      <textarea type="text" name="" id="" value="" v-model="form.description" />

      <label for="">Powers:</label>

      <textarea type="text" name="" id="" value="" v-model="form.powers" />

      <label for="">Phrase:</label>

      <textarea type="text" name="" id="" value="" v-model="form.phrase" />
    </form>

    <label class="upload">
      <input
        type="file"
        multiple="multiple"
        name="files[]"
        v-on:change="onFileChange"
      />
      Choose your hero images
    </label>
    <button type="submit" @click.prevent="editHero">Edit</button>
    <div v-for="(preview, idx) in previews" :key="preview">
      <div>
        <img class="preview" v-bind:ref="'preview' + parseInt(idx)" />
        <button class="deleteImg" @click="deletePreview(idx)">x</button>
      </div>
    </div>
    <ul v-if="this.gotImages == true">
      <li v-for="(image, index) in images" :key="image">
        <img
          :src="images[index]"
          alt=""
          style="width: 400px; height: 400px; max-height: 50%"
        />
        <button @click="deleteImage(index)">x</button>
      </li>
    </ul>
    <button class="deleteHero" @click="deleteHero">Delete Hero</button>
  </div>
</template>

<script>
import api from "../api/api";

export default {
  name: "EditHero",

  data() {
    return {
      form: {
        id: '',
        nick_name: this.$route.params.nick_name,
        real_name: "",
        description: "",
        powers: "",
        phrase: "",
      },
      files: [],
      images: [],
      previews: [],
      gotImages: false
    };
  },

//   updated() {
//     this.getImages();
//   },

  mounted() {
    api
      .get(`/hero/${this.$route.params.nick_name}`)
      .then((response) => {
        this.form.id = response.data.id;
        this.form.real_name = response.data.real_name;
        this.form.description = response.data.description;
        this.form.powers = response.data.powers;
        this.form.phrase = response.data.phrase;
        this.getImages();
        
      })
      .catch((error) => console.log(error));
  },

  methods: {
    onFileChange(e) {
      this.files = e.target.files;
      for (let i = 0; i < this.files.length; i++) {
        this.previews.push(this.files[i]);
      }

      for (let i = 0; i < this.previews.length; i++) {
        let reader = new FileReader();
        reader.addEventListener(
          "load",
          function () {
            this.$refs["preview" + parseInt(i)][0].src = reader.result;
          }.bind(this),
          false
        );

        reader.readAsDataURL(this.previews[i]);
      }
    },

    setImages() {
      let formData = new FormData();

      for (var i = 0; i < this.files.length; i++) {
        let file = this.files[i];
        console.log(file);
        formData.append("files[" + i + "]", file);
      }
      formData.append("id", this.form.id);
      console.log(formData);

      api.post("/setImages", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
    },

    getImages() {
      api
        .get("/getImages", {
          params: { id: this.form.id },
        })
        .then((response) => {
          console.log("he", response.data[response.data.length - 1]);
          for (let i = 0; i < response.data.length; i++) {
            this.images[i] = response.data[i];
          }
          this.gotImages = true;
        })
        .catch((error) => console.log(error));
    },

    editHero() {
      api
        .put("/update", this.form)
        .then((response) => {
          this.$router.push({
            name: "Hero",
            params: { nick_name: this.form.nick_name },
          });
          this.setImages();
          console.log(response);
        })
        .catch((error) => console.log(error));
    },

    deletePreview(index) {
      this.previews.splice(index, 1);
    },

    deleteImage(index) {
      let imageToDelete = this.images[index].split("/").pop();
      this.images.splice(index, 1);
      api.delete("/deleteImage", { params: { image: imageToDelete } });
    },

    deleteHero() {
      api
        .delete(`/delete/${this.form.id}`)
        .then(() => {
          this.$router.push({ name: "Heroes" });
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>
<style scoped>
.container,
form {
  margin-left: 350px;
}
.container,
input,
textarea {
  width: 50%;
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
  border-radius: 6px;
}
button[type="submit"] {
  margin-top: 50px;
  margin-left: 40%;
  width: 50%;
  margin-bottom: 50px;
}
button:hover {
  opacity: 1;
}
ul,
img {
  margin-left: 40%;
}
input[type="file"] {
  margin-top: 50px;
  display: none;
}
.deleteHero,
button {
  width: 50%;
  margin-left: 40%;
}
.upload {
  background-color: #42b983;
  color: white;
  border-radius: 6px;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
  margin-left: 35%;
}
label {
  color: #42b983;
  font-style: italic;
  font-size: 2vh;
}
input[type="text"],
textarea {
  width: 100%;
  height: 7vh;
  font-size: 130%;
  padding: 15px;
  margin: 15px 0 70px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
  border-radius: 4px;
  text-align: center;
}
textarea {
  resize: none;
}
.deleteImg,
button {
  width: 10%;
}
</style>