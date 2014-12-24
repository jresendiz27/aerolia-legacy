package data_management;

/**
 *
 * @author programming
 */
public class Tools {

    private static int parse_data[][] = new int[2][2];
    private static String data_array[][] = new String[2][2];

    public Tools() {
    }

    public static String getDateTime() {
        java.util.Date dt = new java.util.Date();

        java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

        return sdf.format(dt);
    }

    public static String getDateTime(String d) {
        if(d.length()==14){
        //datetime process
            String year,month,day,hour,min,sec;
            year=d.substring(0,4);
            month=d.substring(4,6);
            day=d.substring(6,8);
            hour=d.substring(8,10);
            min=d.substring(10,12);
            sec=d.substring(12,14);
            return year+"-"+month+"-"+day+" "+hour+":"+min+":"+sec;
        } else {
        return getDateTime();
        }
    }

    public static int[][] parseInt(String data_array[][]) throws Exception {
        for (int ix = 0; ix < 2; ix++) {//parsing data
            for (int iy = 0; iy < 2; iy++) {
                parse_data[ix][iy] = Integer.parseInt(data_array[ix][iy], 10);
            }
        }
        return parse_data;
    }

    public static String[][] split(String partial_data) {
        String aux = "", aux2 = "";
        int y = 0, x = 0;
        for (int k = 0; k < partial_data.length(); k++) {
            for (int i = k; i <= k + 5 && i < partial_data.length() + 1; i++) {
                if (aux.length() == 0) {
                    for (int j = k; j < k + 2 && j < partial_data.length(); j++) {
                        aux += partial_data.charAt(j);
                        data_array[x][y] = aux;
                        i = k + 2;
                    }
                }
                if (aux2.length() < 5) {
                    aux2 += partial_data.charAt(i);
                } else if (aux2.length() == 5) {
                    y++;
                    data_array[x][y] = aux2;
                    aux2 = "";
                    aux = "";
                    x++;
                    y--;
                }
                k = i;
            }
        }
        return data_array;
    }    
}
