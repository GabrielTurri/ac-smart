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
    width: 100%;
    text-align: center;
    margin: 16px 0;
    /* margin-top: 16px; */
  }
  a {
    font-size: 16px;
    color: ${props => props.theme['blue-500']};
  }
  span {
    display: block;
    margin-top: 16px;
  }
`;

export const LoginInput = styled.input`
  /* line-height: 2rem; */
  min-width: 20rem;
  padding: 1rem;
  border-radius: 12px;
  border: 0.5px solid ${props => props.theme['blue-300']};
`;

export const LoginNavLink = styled(NavLink)<{ $primary?: boolean;}>`
  width: 100%;
  
  button {
    cursor: pointer;
    background-color: ${props => props.$primary ? props.theme['blue-500'] : props.theme['blue-300']};
    color: white;
    font-size: 1rem;
    font-weight: bold;

    border: none;
    border-radius: 12px;

    width: 100%;
    padding: 16px;
  }
  button:hover{
    background-color: ${props => props.$primary ? props.theme['blue-900'] : props.theme['blue-500']};
    transition: 0.6s;
  }
  `;


