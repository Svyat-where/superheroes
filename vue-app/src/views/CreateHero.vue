<template>
  <div class="container">
    <form>
      <p v-if="this.warning != ''" style="color: red; font-size: 4vh">
        {{ this.warning }}
      </p>
      <label for="">Nick Name</label>

      <input
        type="text"
        name=""
        id=""
        value=""
        v-model="form.nick_name"
        v-on:change="hideWarning"
        placeholder="here must be a nick name"
        required
      />

      <label for="">Real Name:</label>

      <input
        type="text"
        name=""
        id=""
        value=""
        v-model="form.real_name"
        placeholder="here must be a real name"
        required
      />

      <label for="">Description:</label>

      <textarea
        type="text"
        name=""
        id=""
        value=""
        v-model="form.description"
        placeholder="here must be a description"
        required
      />

      <label for="">Powers:</label>

      <textarea
        type="text"
        name=""
        id=""
        value=""
        v-model="form.powers"
        placeholder="here must be powers"
        required
      />

      <label for="">Phrase:</label>

      <textarea
        type="text"
        name=""
        id=""
        value=""
        v-model="form.phrase"
        placeholder="here must be a catch phrase"
        required
      />
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
    <div v-for="(preview, idx) in previews" :key="preview">
      <div>
        <img
          class="preview"
          v-bind:ref="'preview' + parseInt(idx)"
          style="width: 400px; height: 400px; max-height: 50%"
        />
        <button class="delete" @click="deletePreview(idx)">x</button>
      </div>
    </div>
    <div>
      <button class="createHero" type="submit" @click.prevent="createHero">
        Create Hero!
      </button>
    </div>
  </div>
</template>

<script>
import api from "../api/api";

export default {
  name: "create-hero",
  data() {
    return {
      form: {
        nick_name: "",
        real_name: "",
        description: "",
        powers: "",
        phrase: "",
      },
      previews: [],
      warning: "",
    };
  },
  methods: {
    createHero() {
      api
        .post("/create", this.form)
        .then(() => {
          this.$router.push({
            name: "Hero",
            params: { nick_name: this.form.nick_name },
          });
          this.setImages();
        })
        .catch((error) => {
          if (error.response.status == 404) {
            console.log(error.response);
            this.warning = error.response.data;
          }
          console.log(error);
        });
    },
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
    deletePreview(index) {
      this.previews.splice(index, 1);
    },
    setImages() {
      let formData = new FormData();

      for (var i = 0; i < this.files.length; i++) {
        let file = this.files[i];
        console.log(file);
        formData.append("files[" + i + "]", file);
      }
      formData.append("nick_name", this.form.nick_name);

      api.post("/setImages", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
    },
    hideWarning() {
      this.warning = "";
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
.createHero {
  margin-top: 100px;
  margin-left: 38%;
}
.createHero,
button {
  height: 8vh;
  width: 20%;
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
button:hover {
  opacity: 1;
}
.delete,
button {
  width: 50px;
  height: 4vh;
  padding-bottom: 3.8vh;
}
input[type="file"] {
  margin-top: 50px;
  display: none;
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
ul,
img {
  margin-left: 40%;
}
input:placeholder-shown {
  border: 1px solid red;
}
textarea:placeholder-shown {
  border: 1px solid red;
}
</style>
