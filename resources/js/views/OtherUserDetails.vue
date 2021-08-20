<!-- @format -->

<template>
  <div class="row">
    <div class="col-md-6 mt-4" cols="2">
      <h3 style="color: white;">LIKED POKEMON:</h3>

      <ul>
        <li
          v-for="pokemon in unserializeUserData.liked_pokemon"
          :key="pokemon.id"
        >
          <b-col class="mb-4">
            <b-card
              border-variant="primary"
              :header="pokemon.pokemon.toUpperCase()"
              header-bg-variant="danger"
              header-text-variant="white"
              align="center"
            >
              <b-card-text>
                <!-- <router-link ></router-link> -->
                <b-img
                  src="/assets/img/pokeball.png"
                  class="w-20 h-20"
                  center
                  fluid
                  alt="Fluid image"
                ></b-img>
              </b-card-text>
            </b-card>
          </b-col>
        </li>
      </ul>
    </div>

    <div class="col-md-6 mt-4">
      <div>
        <h3 style="color: white;">DISLIKED POKEMON:</h3>

        <ul>
          <li
            v-for="pokemon in unserializeUserData.disliked_pokemon"
            :key="pokemon.id"
          >
            <b-col class="mb-4">
              <b-card
                border-variant="primary"
                :header="pokemon.pokemon.toUpperCase()"
                header-bg-variant="danger"
                header-text-variant="white"
                align="center"
              >
                <b-card-text>
                  <!-- <router-link ></router-link> -->
                  <b-img
                    src="/assets/img/pokeball.png"
                    class="w-20 h-20"
                    center
                    fluid
                    alt="Fluid image"
                  ></b-img>
                </b-card-text>
              </b-card>
            </b-col>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: String,
      required: true
    }
  },
  computed: {
    //decrypting or unserialize data pass from parent components [OtherUser.vue]
    unserializeUserData() {
      return JSON.parse(atob(this.data))
    }
  },
  mounted() {
    console.log(JSON.parse(atob(this.data)))
  }
}
</script>
