<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'
import { route } from 'ziggy-js'

const props = defineProps({
  contact: Object
})

const form = useForm({
  code: props.contact?.code || '',
  name: props.contact?.name || '',
  type: props.contact?.type || 'customer',
  phone: props.contact?.phone || '',
  email: props.contact?.email || '',
  address: props.contact?.address || '',
  notes: props.contact?.notes || ''
})

const isEdit = computed(() => !!props.contact)

const submit = () => {
  if (isEdit.value) {
    form.put(route('master.contacts.update', props.contact.id))
  } else {
    form.post(route('master.contacts.store'))
  }
}

const breadcrumbs = [
  {
    title: 'Contact',
    href: '/master/contacts',
  },
  {
    title: isEdit.value ? 'Edit' : 'Add',
    href: '',
  },
];
</script>

<template>
  <Head :title="isEdit ? 'Edit Contact' : 'Create Contact'" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="max-w-lg mx-auto p-6 shadow rounded">
        <h1 class="text-xl font-bold mb-4">
          {{ isEdit ? 'Edit Contact' : 'Create Contact' }}
        </h1>

        <form @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-sm font-medium">Code</label>
            <input v-model="form.code" type="text" class="w-full border rounded p-2" />
            <div v-if="form.errors.code" class="text-red-500 text-sm">{{ form.errors.code }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Name</label>
            <input v-model="form.name" type="text" class="w-full border rounded p-2" />
            <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Type</label>
            <select v-model="form.type" class="w-full border rounded p-2">
              <option value="customer">Customer</option>
              <option value="vendor">Vendor</option>
            </select>
            <div v-if="form.errors.type" class="text-red-500 text-sm">{{ form.errors.type }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Phone</label>
            <input v-model="form.phone" type="text" class="w-full border rounded p-2" />
            <div v-if="form.errors.phone" class="text-red-500 text-sm">{{ form.errors.phone }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Email</label>
            <input v-model="form.email" type="email" class="w-full border rounded p-2" />
            <div v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Address</label>
            <textarea v-model="form.address" rows="3" class="w-full border rounded p-2"></textarea>
            <div v-if="form.errors.address" class="text-red-500 text-sm">{{ form.errors.address }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Notes</label>
            <textarea v-model="form.notes" rows="3" class="w-full border rounded p-2"></textarea>
            <div v-if="form.errors.notes" class="text-red-500 text-sm">{{ form.errors.notes }}</div>
          </div>

          <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
              {{ isEdit ? 'Update' : 'Create' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
