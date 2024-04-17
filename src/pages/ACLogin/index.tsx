import LogoImg from '../../assets/main-logo.svg'
import { LoginContainer, LoginInput, LoginNavLink, OuStyle } from './styles'

export function ACLogin() {
  return (
    <>
    <LoginContainer>
      <img src={LogoImg} alt="" />
      <h1>Fazer Login</h1>
      <LoginInput placeholder='E-mail'/>
      <LoginInput placeholder='Senha'/>

      <LoginNavLink to='/dashboard' title='Fazer Login' $primary>
        <button>
          Entrar
        </button>
      </LoginNavLink>
      <div>
        <a href="">Esqueci minha senha</a>
        <span>ou</span>
      </div>
      <LoginNavLink to='/' title='Cadastre-se'>
        <button>
          Criar uma conta
        </button>
      </LoginNavLink>
    </LoginContainer>
    </>

    
  );
}