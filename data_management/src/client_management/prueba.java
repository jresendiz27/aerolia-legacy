package client_management;
/**
 *
 * @author Alberto
 */
public class prueba {

    public static void main(String[] args) {
        /*String var="01123450212345";
        System.out.println(Tools.getDateTime("asd"));
        System.out.println(Tools.split(var));*/
        data_reception mi = new data_reception();
        try {
            mi.serial("0X123456789FF");
            mi.date();
        } catch (Exception e) {
        }
        String dato1 = Integer.toString((int) ((int) 10 * Math.random()) * 6);
        String dato2 = Integer.toString((int) ((int) 10000 * Math.random()) * 6);
        String dato3 = Integer.toString((int) ((int) 10 * Math.random()) * 6);
        String dato4 = Integer.toString((int) ((int) 10000 * Math.random()) * 6);
        String dato = "0X" + "01" + "00277" + "12" + "00001" + "FF";
        try {
            mi.receive(dato);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
