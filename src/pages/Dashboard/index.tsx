import { AppHeader, DashboardContainer, ChartContainer, Button, ChartImg } from './styles'
import { Menu, FileText } from 'react-feather'

export function Dashboard() {
  return (
    <>
    <AppHeader>
      <Menu color='#fff' />
    </AppHeader>

    <h1>Dashboard</h1>
    <DashboardContainer>
      <ChartContainer>
        <ChartImg></ChartImg>
        <h1>Teste</h1>

      </ChartContainer>

      <ChartContainer>
        <Button><FileText/>Minhas AC'S</Button>
        <Button>Entregar AC'S</Button>
        <Button>AC'S Reprovadas</Button>
      </ChartContainer>
    </DashboardContainer>
    
    </>
  );
}