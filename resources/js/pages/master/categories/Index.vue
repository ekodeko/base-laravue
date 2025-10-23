<template>
  <Head title="Categories" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div>
        <Link href="/master/categories/create">
          <Button>
            + Add Category
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
                  <TableHead>Parent</TableHead>
                  <TableHead class="text-right">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="category in filteredData" :key="category.id">
                  <TableCell class="font-medium">{{ category.code }}</TableCell>
                  <TableCell>{{ category.name }}</TableCell>
                  <TableCell>
                    <span
                      :class="[
                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium',
                        category.type === 'income'
                          ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20'
                          : 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20'
                      ]"
                    >
                      {{ category.type }}
                    </span>
                  </TableCell>
                  <TableCell>{{ category.parent?.name ?? '-' }}</TableCell>
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
                          <Link :href="'/master/categories/'+category.id+'/edit'">Edit</Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                          <Link method="delete" :href="`/master/categories/${category.id}`" as="button"
                            class="w-full text-red-600">
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
import { Head, Link } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps({
  categories: Object
})

const meta = props.categories.meta
const links = props.categories.links

const breadcrumbs = [
  {
    title: 'Category',
    href: '/master/categories',
  },
];

const search = ref("")

// filtering sederhana
const filteredData = computed(() => {
  if (!search.value) return props.categories.data
  return props.categories.data.filter(row =>
    Object.values(row).some(v =>
      String(v).toLowerCase().includes(search.value.toLowerCase())
    )
  )
})
</script>
