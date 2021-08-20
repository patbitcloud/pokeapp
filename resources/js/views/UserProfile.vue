<!-- @format -->

<template>
  <div>
    <b-col class="mb-4">
      <b-form @submit.prevent="submitProfileForm" v-if="show_profile_form">
        <b-form-group
          id="input-group-2"
          label="First Name:"
          label-for="input-2"
          class="mb-2"
        >
          <b-form-input
            id="input-2"
            v-model.trim="profile_form.first_name"
          ></b-form-input>
          <b-form-invalid-feedback
            :state="hasFormError(profile_form, 'first_name').status"
          >
            {{ hasFormError(profile_form, 'first_name').message }}
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
          id="input-group-3"
          label="Last Name:"
          label-for="input-3"
          class="mb-4"
        >
          <b-form-input
            id="input-3"
            v-model.trim="profile_form.last_name"
          ></b-form-input>
          <b-form-invalid-feedback
            :state="hasFormError(profile_form, 'last_name').status"
          >
            {{ hasFormError(profile_form, 'last_name').message }}
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
          id="input-group-4"
          label="Birthday:"
          label-for="input-4"
          class="mb-4"
        >
          <b-col class="ml-4">
            <b-form-input
              type="date"
              class="mb-4"
              id="input-4"
              v-model.trim="profile_form.birth_date"
            ></b-form-input>
            <b-form-invalid-feedback
              :state="hasFormError(profile_form, 'birth_date').status"
            >
              {{ hasFormError(profile_form, 'birth_date').message }}
            </b-form-invalid-feedback>
          </b-col>
        </b-form-group>

        <b-form-group
          id="input-group-1"
          label="Email address:"
          label-for="input-1"
          class="mb-4"
        >
          <b-form-input
            id="input-1"
            v-model.trim="profile_form.email"
            type="email"
          ></b-form-input>
          <b-form-invalid-feedback
            :state="hasFormError(profile_form, 'email').status"
          >
            {{ hasFormError(profile_form, 'email').message }}
          </b-form-invalid-feedback>
        </b-form-group>
        <div class="oppa">
          <b-button type="submit" variant="primary">Update Profile</b-button>
        </div>
      </b-form>

      <b-form @submit.prevent="submitPasswordForm" v-if="show_profile_form">
        <b-form-group
          id="input-group-9"
          label="Current Password:"
          label-for="input-9"
          class="mb-2"
        >
          <b-form-input
            type="password"
            id="input-9"
            v-model.trim="password_form.current_password"
          ></b-form-input>
          <b-form-invalid-feedback
            :state="hasFormError(password_form, 'current_password').status"
          >
            {{ hasFormError(password_form, 'current_password').message }}
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
          id="input-group-8"
          label="New Password:"
          label-for="input-8"
          class="mb-2"
        >
          <b-form-input
            type="password"
            id="input-8"
            v-model.trim="password_form.new_password"
          ></b-form-input>
          <b-form-invalid-feedback
            :state="hasFormError(password_form, 'new_password').status"
          >
            {{ hasFormError(password_form, 'new_password').message }}
          </b-form-invalid-feedback>
        </b-form-group>

        <b-form-group
          id="input-group-7"
          label="New Password Confirmation:"
          label-for="input-7"
          class="mb-2"
        >
          <b-form-input
            type="password"
            id="input-7"
            v-model.trim="password_form.new_password_confirmation"
          ></b-form-input>
          <b-form-invalid-feedback
            :state="
              hasFormError(password_form, 'new_password_confirmation').status
            "
          >
            {{
              hasFormError(password_form, 'new_password_confirmation').message
            }}
          </b-form-invalid-feedback>
        </b-form-group>

        <div class="oppa">
          <b-button type="submit" variant="primary">Update Password</b-button>
        </div>
      </b-form>
    </b-col>
  </div>
</template>

<script>
import http from '../utils/http'
export default {
  data() {
    return {
      profile_form: this.editProfileForm(),
      password_form: this.editPasswordForm(),
      show_profile_form: true
    }
  },
  props: {
    authUser: {
      type: Object,
      required: true
    }
  },
  methods: {
    //update profile information
    async submitProfileForm() {
      try {
        const { data } = await http.put(
          `/user/update/${this.authUser.id}`,
          this.profile_form
        )
        alert(data.message)
        window.location.reload()
      } catch (error) {
        if (error.response.status === 422) {
          this.profile_form.errors = error.response.data.errors
          alert(error.response.data.message)
        }
        console.error(error.message)
      } finally {
      }
    },
    //update profile password
    async submitPasswordForm() {
      try {
        const { data } = await http.put(
          `/user/update-password/${this.authUser.id}`,
          this.password_form
        )
        alert(data.message)
        window.location.reload()
      } catch (error) {
        if (error.response.status === 422) {
          this.password_form.errors = error.response.data.errors
          alert(error.response.data.message)
        }
      }
    },
    //validation form
    hasFormError(form, field) {
      const hasProperty = form.errors.hasOwnProperty(field)
      return {
        status: hasProperty === false,
        message: hasProperty ? form.errors[field][0] : null
      }
    },
    editProfileForm() {
      return {
        email: '',
        first_name: '',
        last_name: '',
        birth_date: '',
        errors: {}
      }
    },
    editPasswordForm() {
      return {
        current_password: '',
        new_password: '',
        new_password_confirmation: '',
        errors: {}
      }
    }
  },
  mounted() {
    this.profile_form.first_name = this.authUser.first_name
    this.profile_form.last_name = this.authUser.last_name
    this.profile_form.email = this.authUser.email
    this.profile_form.birth_date = this.authUser.birth_date
  }
}
</script>

<style scoped>
.oppa {
  position: relative;
  text-align: center;
}
</style>
