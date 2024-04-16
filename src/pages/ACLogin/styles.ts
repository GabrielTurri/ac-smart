import { NavLink } from "react-router-dom";
import { styled,  } from "styled-components";

export const LoginContainer = styled.div`
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  text-align: center;
  align-items: center;

  display: flex;
  flex-direction: column;
  gap: 8px;

  img {
    height: 160px;
    width: 160px;
    margin-bottom: 32px;
  }
  div {
    display: flex;
    width: 100%;
    padding: 0 8px;
    margin-bottom: 16px;

    justify-content: space-between;

  }
  a {
    font-size: 12px;
    color: ${props => props.theme['blue-500']};
  }
`;

export const LoginInput = styled.input`
  /* line-height: 2rem; */
  min-width: 20rem;
  padding: 1rem;
  border-radius: 12px;
  border: 0.5px solid ${props => props.theme['blue-300']};
`;

export const LoginNavLink = styled(NavLink)`
  width: 100%;
  
  button {
    background-color: ${props => props.theme['blue-500']};
    color: white;
    font-size: 1rem;
    font-weight: bold;

    border: none;
    border-radius: 12px;

    width: 100%;
    padding: 16px;
  }
`;


