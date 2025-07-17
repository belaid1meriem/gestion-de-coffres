import { useField, useForm } from 'vee-validate';
import * as yup from 'yup';
import useVaults from '../useVaults';

export default function useVaultNameForm(initialValues: {name: string} = { name: '' }, id?: number) {
  const schema = yup.object({
    name: yup.string().required()
  });

  type LoginForm = yup.InferType<typeof schema>;

  const { handleSubmit } = useForm<LoginForm>({
    validationSchema: schema,
    initialValues
  });

  const { value: name, errorMessage: nameError } = useField<LoginForm['name']>('name');

  const { 
    isCreating,
    createError,
    createSuccess,
    createVault,

    isUpdatingName,
    updateNameError,
    updateNameSuccess,
    updateNameVault,
   } = useVaults();

  const onSubmit = handleSubmit(async ({name})=>{
    if(id){
        await updateNameVault(id, name)
    }
    else{
        await createVault(name)
    }
  })

  if(id){
    return {
      name,
      nameError,

      isLoading: isUpdatingName,
      error: updateNameError,
      success: updateNameSuccess,

      onSubmit
    };
  }
  else{
    return {
      name,
      nameError,

      isLoading: isCreating,
      error: createError,
      success: createSuccess,

      onSubmit
    };
  }

}
