<script setup>
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import FormField from '@/components/ui/form/FormField.vue';
import FormItem from '@/components/ui/form/FormItem.vue';
import FormLabel from '@/components/ui/form/FormLabel.vue';
import FormMessage from '@/components/ui/form/FormMessage.vue';
import Input from '@/components/ui/form/Input.vue';
import Select from '@/components/ui/form/Select.vue';
import Textarea from '@/components/ui/form/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
  contact: Object,
});

const breadcrumbs = [
  {
    title: 'Contact',
    href: '/master/contacts',
  },
  {
    title: 'Edit',
    href: `/master/contacts/${props.contact.id}/edit`,
  },
];

const form = useForm({
  code: props.contact.code,
  name: props.contact.name,
  type: props.contact.type,
  phone: props.contact.phone,
  email: props.contact.email,
  address: props.contact.address,
  notes: props.contact.notes,
});

const submit = () => {
  form.put(`/master/contacts/${props.contact.id}`);
};
</script>

<template>
  <Head title="Edit Contact" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 p-4">
      <Card>
        <CardHeader>
          <CardTitle>Edit Contact</CardTitle>
          <CardDescription>Edit contact information</CardDescription>
        </CardHeader>
        <CardContent>
          <form @submit.prevent="submit" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <FormField>
                <FormItem>
                  <FormLabel>Code</FormLabel>
                  <Input v-model="form.code" type="text" />
                  <FormMessage>{{ form.errors.code }}</FormMessage>
                </FormItem>
              </FormField>

              <FormField>
                <FormItem>
                  <FormLabel>Name</FormLabel>
                  <Input v-model="form.name" type="text" />
                  <FormMessage>{{ form.errors.name }}</FormMessage>
                </FormItem>
              </FormField>

              <FormField>
                <FormItem>
                  <FormLabel>Type</FormLabel>
                  <Select v-model="form.type">
                    <option value="customer">Customer</option>
                    <option value="vendor">Vendor</option>
                  </Select>
                  <FormMessage>{{ form.errors.type }}</FormMessage>
                </FormItem>
              </FormField>

              <FormField>
                <FormItem>
                  <FormLabel>Phone</FormLabel>
                  <Input v-model="form.phone" type="text" />
                  <FormMessage>{{ form.errors.phone }}</FormMessage>
                </FormItem>
              </FormField>

              <FormField>
                <FormItem>
                  <FormLabel>Email</FormLabel>
                  <Input v-model="form.email" type="email" />
                  <FormMessage>{{ form.errors.email }}</FormMessage>
                </FormItem>
              </FormField>
            </div>

            <FormField>
              <FormItem>
                <FormLabel>Address</FormLabel>
                <Textarea v-model="form.address" />
                <FormMessage>{{ form.errors.address }}</FormMessage>
              </FormItem>
            </FormField>

            <FormField>
              <FormItem>
                <FormLabel>Notes</FormLabel>
                <Textarea v-model="form.notes" />
                <FormMessage>{{ form.errors.notes }}</FormMessage>
              </FormItem>
            </FormField>

            <div class="flex justify-end space-x-2">
              <Button variant="secondary" :href="route('master.contacts.index')">
                Cancel
              </Button>
              <Button type="submit" :disabled="form.processing">Update Contact</Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
