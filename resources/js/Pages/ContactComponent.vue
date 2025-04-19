<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- Header -->
        <template #header>
            <h2 class="text-2xl font-bold text-gray-800">Contacts</h2>
        </template>

        <!-- Message de bienvenue -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-6 text-gray-800 text-lg font-medium">
                        You're logged in!
                        <p class="mt-4 text-gray-600 text-sm">
                            dfcs, os, spggsdgfqsdgpspghqsd, kk, p
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Contacts -->
        <div class="max-w-4xl mx-auto px-4 pb-16">
            <h1 class="text-xl font-semibold text-gray-700 mb-6">Add New Contact</h1>

            <!-- Formulaire d'ajout -->
            <contact-form-component @contact-added="fetchContacts" />

            <!-- Liste des contacts -->
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <contact-card-component
                    v-for="contact in contacts"
                    :key="contact.id"
                    :contact="contact"
                    @contact-deleted="fetchContacts"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>



<script>
import ContactCardComponent from './ContactCardComponent.vue';
import ContactFormComponent from './ContactFormComponent.vue';

export default {
  components: {
    ContactFormComponent,
    ContactCardComponent,
  },
  data() {
    return {
      contacts: [],
    };
  },
  methods: {
    fetchContacts() {
      axios.get('/contacts').then(response => {
        this.contacts = response.data;
      });
    },
  },
  created() {
    this.fetchContacts();
  },
};
</script>