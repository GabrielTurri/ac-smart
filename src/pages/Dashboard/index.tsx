import { AppHeader, DashboardContainer, ChartContainer, Button } from './styles'
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
      <h1>Teste</h1>
      <h1>Teste</h1>

      </ChartContainer>

      <ChartContainer>
        <Button><FileText/>Minhas AC'S</Button>
        <Button>Minhas AC'S</Button>
        <Button>Minhas AC'S</Button>
      </ChartContainer>
    </DashboardContainer>
    
    </>
  );
}