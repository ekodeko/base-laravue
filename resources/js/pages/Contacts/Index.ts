import { defineComponent } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { Table } from '@/components/ui/table'
import { Button } from '@/components/ui/button'

export default defineComponent({
  components: {
    AppLayout,
    Head,
    Link,
    Table,
    Button
  },
  props: {
    contacts: {
      type: Object,
      required: true
    }
  },
  setup() {
    const columns = [
      {
        key: 'code',
        label: 'Code'
      },
      {
        key: 'name',
        label: 'Name'
      },
      {
        key: 'type',
        label: 'Type'
      },
      {
        key: 'phone',
        label: 'Phone'
      },
      {
        key: 'email',
        label: 'Email'
      },
      {
        key: 'actions',
        label: 'Actions'
      }
    ]

    return {
      columns
    }
  }
})
