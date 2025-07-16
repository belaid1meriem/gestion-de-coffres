// composables/useSignupForm.ts
import { useField, useForm } from 'vee-validate';
import * as yup from 'yup';
import useSignup from '../useSignup';

export default function useSignupForm() {
  const schema = yup.object({
    email: yup.string().required().email(),
    password: yup.string().required().min(6),
    firstName: yup.string().required().min(2).max(50),
    lastName: yup.string().required().min(2).max(50)
  });

  type SignupForm = yup.InferType<typeof schema>;

  const { handleSubmit } = useForm<SignupForm>({
    validationSchema: schema,
    initialValues: {
      email: '',
      password: '',
      firstName: '',
      lastName: ''
    },
  });

  const { value: email, errorMessage: emailError } = useField<SignupForm['email']>('email');
  const { value: password, errorMessage: passwordError } = useField<SignupForm['password']>('password');
  const { value: firstName, errorMessage: firstNameError } = useField<SignupForm['firstName']>('firstName');
  const { value: lastName, errorMessage: lastNameError } = useField<SignupForm['lastName']>('lastName');

  const { signup, error, isLoading } = useSignup();

  const onSubmit = handleSubmit(async ({email, password, lastName, firstName})=>{
    await signup(email,firstName, lastName, password )
  })

  return {
    email,
    password,
    emailError,
    passwordError,
    lastName,
    lastNameError,
    firstName,
    firstNameError,
    error,
    isLoading,
    onSubmit
  };
}
