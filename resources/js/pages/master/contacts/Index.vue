<script setup>
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import Button from '@/components/ui/button/Button.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3'
import { MoreHorizontal } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps({
  contacts: Object
})

const meta = computed(() => props.contacts.meta)
const links = computed(() => props.contacts.links)

const breadcrumbs = [
  {
    title: 'Contact',
    href: '/master/contacts',
  },
];

const search = ref("")

// filtering sederhana
const filteredData = computed(() => {
  if (!search.value) return props.contacts.data
  return props.contacts.data.filter(row =>
    Object.values(row).some(v =>
      String(v).toLowerCase().includes(search.value.toLowerCase())
    )
  )
})
</script>

<template>
  <Head title="Contacts" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div>
        <Link href="/master/contacts/create">
          <Button>
            + Add Contact
          </Button>
        </Link>

        <div class="space-y-4 mt-4">
          <!-- Toolbar -->
          <div class="flex items-center justify-between">
            <input v-model="search" type="text" placeholder="Filter data..."
              class="w-1/3 rounded-md border px-3 py-2 text-sm bg-background" />
          </div>
          <!-- Table -->
          <div class="border rounded-lg shadow-sm mt-4 space-y">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Code</TableHead>
                  <TableHead>Name</TableHead>
                  <TableHead>Type</TableHead>
                  <TableHead>Phone</TableHead>
                  <TableHead>Email</TableHead>
                  <TableHead class="text-right">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="contact in filteredData" :key="contact.id">
                  <TableCell class="font-medium">{{ contact.code }}</TableCell>
                  <TableCell>{{ contact.name }}</TableCell>
                  <TableCell class="capitalize">{{ contact.type }}</TableCell>
                  <TableCell>{{ contact.phone ?? '-' }}</TableCell>
                  <TableCell>{{ contact.email ?? '-' }}</TableCell>
                  <TableCell class="text-right">
                    <DropdownMenu>
                      <DropdownMenuTrigger as-child>
                        <Button variant="ghost" size="icon">
                          <MoreHorizontal class="h-4 w-4" />
                        </Button>
                      </DropdownMenuTrigger>
                      <DropdownMenuContent align="end">
                        <DropdownMenuLabel>Actions</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem as-child>
                          <Link :href="'/master/contacts/'+contact.id+'/edit'">Edit</Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                          <Link :href="'/master/contacts/'+contact.id" method="delete" as="button" class="w-full text-red-600">
                            Delete
                          </Link>
                        </DropdownMenuItem>
                      </DropdownMenuContent>
                    </DropdownMenu>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>
          <!-- Pagination -->
          <div class="mt-4">
            <PaginationWrapper :meta="meta" :links="links" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
