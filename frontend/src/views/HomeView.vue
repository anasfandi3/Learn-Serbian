<template>
  <div class="container">
    <div class="row d-flex justify-content-center p-3">
      <div class="col-12 mb-4">
        <div class="row d-flex justify-content-center">
          <div class="col-md-6 d-flex justify-content-center">
            <h1>Learn Serbian</h1>
          </div>
        </div>
      </div>
      <div class="col-lg-10 col-md-11 p-3" style="background-color: #FFFFFF">
        <div class="row d-flex justify-content-center media-container">
          <div class="col-lg-7 col-md-4 col-sm-12 my-1">
            <img class="display-image mb-4" :src="`public/${currentWord?.image_name}`" />
            <div class="w-100 text-center mb-4">
              <h5>{{currentWord?.word}}</h5>
            </div>
            <div class="row d-flex justify-content-center mb-4">
              <div class="col-md-12 col-sm-10">
                <input
                  type="text"
                  class="orange-shadow"
                  v-model="userInput"
                  v-on:keyup.enter="checkAnswer"
                />
              </div>
            </div>
            <div class="row d-flex justify-content-center mb-4">
              <div class="col-md-6 col-sm-10">
                <button class="submit-button w-100" @click="checkAnswer">Let's see</button>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-4 col-sm-12 my-1">
            <div class="row" style="color: #ff6700">
              <div class="col-6 d-flex align-items-center left-thumb-container">
                <i class="fa-solid fa-thumbs-up mx-2"></i>
                <span>{{correctAnswers}} / {{correctAnswers + wrongAnswers}}</span>
              </div>
              <div class="col-6 d-flex align-items-center right-thumb-container">
                <i class="fa-solid fa-thumbs-down mx-2"></i>
                <span>{{wrongAnswers}} / {{correctAnswers + wrongAnswers}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomeView",
  data() {
    return {
      words: [],
      correctAnswers: 0,
      wrongAnswers: 0,
      userInput: "",
      currentWord: {}
    };
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      this.axios
        .get("http://127.0.0.1:8000/api/translations")
        .then((response) => {
          this.words = response.data.data;
          this.words.forEach((el) => {
            el.answered = false;
          });
          this.getCurrentWord();
        });
    },
    checkAnswer() {
      if (!this.userInput) return;
      this.axios
        .post(`http://127.0.0.1:8000/api/check_answer/${this.currentWord.id}`, {
          answer: this.userInput,
          is_english: this.currentWord.is_english,
        })
        .then((response) => {
          let message = response.data.message;
          if (message == "correct") {
            this.correctAnswers++;
            this.currentWord.answered = true;
          } else if (message == "wrong") {
            this.wrongAnswers++;
          }
          this.userInput = "";
          let temp = this.words.shift();
          this.words.push(temp);
          this.getCurrentWord()
        });
    },
    getCurrentWord() {
      this.currentWord = this.words.find(el => {
        return el.answered == false;
      })
      if (!this.currentWord) {
        this.resetAll();
      }
    },
    resetAll(){
      alert(`Game over. your score => correct: ${this.correctAnswers}, wrong: ${this.wrongAnswers}`);
      this.correctAnswers = 0;
      this.wrongAnswers = 0;
      this.getData();
    }
  },
};
</script>

<style scoped>
.display-image {
  width: 100%;
  border-radius: 10px;
}
.orange-shadow {
  box-shadow: 6px -6px 10px 0px #e7bea34d;
  box-shadow: -6px 6px 10px 0px #ff67004d;
  display: block;
  width: 100%;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #212529;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 10px;
}
.orange-shadow:focus-visible,
.orange-shadow:focus {
  border: 1px solid #ced4da !important;
  outline: none;
}
.submit-button {
  border-radius: 10px;
  background: #ff6700;
  border: none;
  min-height: 30px;
}
.left-thumb-container,
.right-thumb-container {
  justify-content: center;
}
.media-container {
  flex-direction: column;
  align-items: center;
}
@media (max-width: 740px) {
  .media-container {
    flex-direction: column-reverse !important;
  }
  .left-thumb-container {
    justify-content: start !important;
  }
  .right-thumb-container {
    justify-content: end !important;
  }
}
</style>