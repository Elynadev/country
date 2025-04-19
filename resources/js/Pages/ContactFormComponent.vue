<!-- resources/js/Pages/ContactFormComponent.vue -->
<template>
    <div class="max-w-xl mx-auto p-8 bg-white shadow-xl rounded-2xl border border-gray-100">
      <div class="mb-6 p-4 bg-blue-50 text-blue-700 font-semibold rounded-md text-center shadow-sm">
        <span class="text-lg tracking-wide">📇 NOX Contact Manager</span>
      </div>
  
      <h2 class="text-2xl font-extrabold mb-6 text-gray-800 border-b pb-2">Add a New Contact</h2>
  
      <form @submit.prevent="addContact" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input
            v-model="form.name"
            type="text"
            placeholder="John Doe"
            required
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition"
          />
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="form.email"
            type="email"
            placeholder="john@example.com"
            required
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
          />
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700">Phone</label>
          <input
            v-model="form.phone"
            type="text"
            placeholder="+229 00 00 00 00"
            required
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
          />
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700">Company</label>
          <input
            v-model="form.company"
            type="text"
            placeholder="Elyna Market"
            required
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
          />
        </div>
  
        <div>
          <label class="block text-sm font-medium text-gray-700">Country</label>
          <select
            v-model="form.country"
            @change="setCountryFlag"
            required
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
          >
            <option value="" disabled>Select a country</option>
            <option
              v-for="country in countries"
              :key="country.name.common"
              :value="country.name.common"
            >
              {{ country.name.common }}
            </option>
          </select>
        </div>
  
        <div class="pt-4">
          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200"
          >
            Add Contact
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';
import { onMounted, ref } from 'vue';
  
  export default {
    setup() {
      const form = ref({
        name: '',
        email: '',
        phone: '',
        company: '',
        country: '',
        country_flag: null
      });
      const countries = ref([]);
  
      const addContact = () => {
        Inertia.post('/contacts', form.value, {
          onSuccess: () => {
            form.value = {
              name: '',
              email: '',
              phone: '',
              company: '',
              country: '',
              country_flag: null
            };
          },
          onError: (errors) => {
            if (errors.status === 422) {
              alert('Validation failed. Please check your inputs.');
            } else {
              alert('An error occurred. Please try again.');
            }
          }
        });
      };
  
      const fetchCountries = () => {
        axios.get('https://restcountries.com/v3.1/all')
          .then(response => {
            countries.value = response.data;
          })
          .catch(error => {
            console.error('Error fetching countries:', error);
          });
      };
  
      const setCountryFlag = () => {
        const selectedCountry = countries.value.find(
          country => country.name.common === form.value.country
        );
        if (selectedCountry?.flags?.png) {
          form.value.country_flag = selectedCountry.flags.png;
        } else {
          form.value.country_flag = null;
        }
      };
  
      onMounted(() => {
        fetchCountries();
      });
  
      return {
        form,
        countries,
        addContact,
        setCountryFlag
      };
    }
  };
  </script>
  