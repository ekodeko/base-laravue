import { defineComponent } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { Card } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Select } from '@/components/ui/select'

export default defineComponent({
  components: {
    AppLayout,
    Head,
    Card,
    Input,
    Button,
    Select
  },
  setup() {
    const form = useForm({
      code: '',
      name: '',
      type: '',
      phone: '',
      email: '',
      address: ''
    })

    const submit = () => {
      form.post('/contacts')
    }

    return {
      form,
      submit
    }
  }
})
