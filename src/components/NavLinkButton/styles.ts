import { styled } from 'styled-components'
import { NavLink } from 'react-router-dom';

export const NavLinkButton = styled(NavLink)`
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  gap: 8px;

  width: 100%;
  background-color: ${props => props.theme['blue-500']};
  color: #fff;
  font-size: 1rem;
  font-weight: bold;
  
  cursor: pointer;
  text-decoration: none;
  border: none;
  border-radius: 12px;
  padding: 16px;
  
  width: 100%;
  color: white;
  
  
  &:hover{
    background-color: ${props => props.theme['blue-900']};
    transition: 0.6s;
  }
`;
