import { useField, useForm } from 'vee-validate';
import * as yup from 'yup';
import useLogin from '../useLogin';

export default function useLoginForm() {
  const schema = yup.object({
    email: yup.string().required().email(),
    password: yup.string().required().min(6),
  });

  type LoginForm = yup.InferType<typeof schema>;

  const { handleSubmit } = useForm<LoginForm>({
    validationSchema: schema,
    initialValues: {
      email: '',
      password: '',
    },
  });

  const { value: email, errorMessage: emailError } = useField<LoginForm['email']>('email');
  const { value: password, errorMessage: passwordError } = useField<LoginForm['password']>('password');

  const { login, error, isLoading } = useLogin();

  const onSubmit = handleSubmit(async ({email, password})=>{
    await login(email, password)
  })

  return {
    email,
    password,
    emailError,
    passwordError,
    error,
    isLoading,
    onSubmit
  };
}
