import LogoImg from '../../assets/main-logo.svg'
import { LoginContainer, LoginInput, LoginNavLink } from './styles'

export function ACLogin() {
  return (
    <>
    <LoginContainer>
      <img src={LogoImg} alt="" />
      <h1>Fazer Login</h1>
      <LoginInput placeholder='E-mail'/>
      <LoginInput placeholder='Senha'/>

      <div>
        <a href="">Cadastre-se</a>
        <a href="">Esqueci minha senha</a>
      </div>
      <LoginNavLink to='/dashboard' title='Fazer Login'>
        <button>
          ENTRAR
        </button>
      </LoginNavLink>
    </LoginContainer>
    </>

    
  );
}