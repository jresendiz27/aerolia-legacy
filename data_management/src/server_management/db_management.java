package server_management;

import data_management.EolikContent;
import data_management.FileManager;
import data_management.HistoryContent;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

/**
 *
 * @author Alberto
 */
public class db_management {

    private static Connection conn;
    private static Statement stmnt = null;
    private static int type;
    private static int value;
    private static int parse_data[][] = new int[2][2];
    private static String url;
    private static String dbName;
    private static String driver;
    private static String userName;
    private static String password;

    static {
        url = "jdbc:mysql://localhost:3306/";
        dbName = "aerolia";
        driver = "com.mysql.jdbc.Driver";
        userName = "root";
        password = "n0m3l0s3";
    }

    public static void connect() {
        try {
            Class.forName(driver).newInstance();
            conn = (Connection) DriverManager.getConnection(url + dbName, userName, password);
            System.out.println("Conexion exitosa!");
        } catch (Exception e) {
            //e.printStackTrace();
            conn = null;
        }
    }

    public static void connect(String host, String db, String user, String pass) {
        url = "jdbc:mysql://" + host + "/";
        dbName = db;
        driver = "com.mysql.jdbc.Driver";
        userName = user;
        password = pass;
        try {
            Class.forName(driver).newInstance();
            conn = (Connection) DriverManager.getConnection(url + dbName, userName, password);
            //System.out.println("Conexion exitosa!");
        } catch (Exception e) {
            conn = null;
        }
    }

    public static boolean insertContentObject(EolikContent ec) throws InterruptedException {
        //connect();
        System.out.println("entro al metodo");
        if (conn == null) {
            try {//todos los datos bien pero al parecer no hay conexion en la bd                
                FileManager.saveData(ec);
                Thread.sleep(60000);
                connect();
                insertContentObject(ec);
            } catch (Exception e) {
                e.printStackTrace();
            }
            return false;
        } else {
            try {
                System.out.println("entro al try para insertar");
                stmnt = conn.createStatement();
                parse_data = ec.getParse_data();
                for (int ix = 0; ix < 2; ix++) {
                    for (int iy = 0; iy < 2; iy++) {
                        switch (iy) {
                            case 0:
                                type = parse_data[ix][iy];
                                break;
                            case 1:
                                value = parse_data[ix][iy];
                                break;
                        }
                    }
                    try {
                        if (type < 6) {
                            stmnt.executeUpdate("INSERT INTO m_dato(id_aero,id_tipodato,val_dato,fec_dato) VALUES (" + ec.getSerial_number() + "," + type + "," + value + ",'" + ec.getDate() + "')");
                        } else {
                            stmnt.executeUpdate("INSERT INTO m_historial(id_aero,id_tipodato,val_dato,fec_dato) VALUES (" + ec.getSerial_number() + "," + type + "," + value + ",'" + ec.getDate() + "')");
                        }
                        //System.out.println(ec);
                        //System.out.println("--- fecha "+ec.getDate());
                        //System.out.println("--- datos "+ec.getParse_data()[0][0]);
                        //System.out.println("--- serial "+ec.getSerial_number());
                        //System.out.println("INSERT INTO m_dato(id_aero,id_tipodato,val_dato,fec_dato) VALUES (" + ec.getSerial_number() + "," + type + "," + value + ",'" + ec.getDate() + "')");
                        //System.in.read();
                        type = 0;
                        value = 0;
                        //return true;

                    } catch (Exception e) {
                        FileManager.saveData(ec);
                        e.printStackTrace();
                        //return false;
                    }
                }
            } catch (Exception ex) {
                //ex.printStackTrace();
                return false;
            }
            return true;
        }
    }

    public static boolean insertContentArray(ArrayList<EolikContent> ec) throws InterruptedException {
        //connect();
        System.out.println("entro al metodo");
        if (conn == null) {
            try {//todos los datos bien pero al parecer no hay conexion en la bd
                FileManager.saveData(ec);
                Thread.sleep(60000);
                connect();
                insertContentArray(ec);
            } catch (Exception e) {
                // e.printStackTrace();
            }
            return false;
        } else {
            try {
                System.out.println("entro al try para insertar");
                stmnt = conn.createStatement();
                for (int i = 0; i < ec.size(); i++) {
                    parse_data = ec.get(i).getParse_data();
                    for (int ix = 0; ix < 2; ix++) {
                        for (int iy = 0; iy < 2; iy++) {
                            switch (iy) {
                                case 0:
                                    type = parse_data[ix][iy];
                                    break;
                                case 1:
                                    value = parse_data[ix][iy];
                                    break;
                            }
                        }
                        try {
                            if (type < 6) {
                                stmnt.executeUpdate("INSERT INTO m_dato(id_aero,id_tipodato,val_dato,fec_dato) VALUES (" + ec.get(i).getSerial_number() + "," + type + "," + value + ",'" + ec.get(i).getDate() + "')");
                            } else {
                                stmnt.executeUpdate("INSERT INTO m_historial(id_aero,id_tipodato,val_dato,fec_dato) VALUES (" + ec.get(i).getSerial_number() + "," + type + "," + value + ",'" + ec.get(i).getDate() + "')");
                            }
                            type = 0;
                            value = 0;
                            //return true;

                        } catch (Exception e) {
                            FileManager.saveData(ec);
                            //return false;
                        }
                    }
                }
            } catch (Exception ex) {
                ex.printStackTrace();
                return false;
            }
            return true;
        }
    }

    public static boolean insertLogObject(HistoryContent hc) {
        System.out.println("entro al metodo");
        if (conn == null) {
            try {//todos los datos bien pero al parecer no hay conexion en la bd                
                FileManager.saveLog(hc);
                Thread.sleep(60000);
                connect();
                insertLogObject(hc);
            } catch (Exception e) {
                // e.printStackTrace();
            }
            return false;
        } else {
            try {
                System.out.println("entro al try para insertar");
                stmnt = conn.createStatement();
                try {
                    if (type < 6) {
                        stmnt.executeUpdate("INSERT INTO m_dato(id_aero,id_tipodato,val_dato,fec_dato) VALUES (" + hc.getSerial() + "," + type + "," + value + ",'" + hc.getDate() + "')");
                    } else {
                        stmnt.executeUpdate("INSERT INTO m_historial(id_aero,id_tipodato,val_dato,fec_dato) VALUES (" + hc.getSerial() + "," + type + "," + value + ",'" + hc.getDate() + "')");
                    }
                    type = 0;
                    value = 0;
                } catch (Exception e) {
                    FileManager.saveLog(hc);
                }
            } catch (Exception ex) {
                ex.printStackTrace();
            }
        }
        return true;
    }

    public static boolean insertLogArray(ArrayList<HistoryContent> hc) {
        System.out.println("entro al metodo");
        if (conn == null) {
            try {//todos los datos bien pero al parecer no hay conexion en la bd
                FileManager.saveLog(hc);
                Thread.sleep(60000);
                connect();
                insertLogArray(hc);
            } catch (Exception e) {
                // e.printStackTrace();
            }
            return false;
        } else {
            try {
                System.out.println("entro al try para insertar");
                stmnt = conn.createStatement();
                for (int i = 0; i < hc.size(); i++) {
                    try {
                        stmnt.executeUpdate("INSERT INTO m_historial(id_aero,id_evento,fecha_historial) VALUES (" + hc.get(i).getSerial() + "," + hc.get(i).getId_error() + ",'" + hc.get(i).getDate() + "')");
                        type = 0;
                        value = 0;
                    } catch (Exception e) {
                        FileManager.saveLog(hc);
                    }
                }
            } catch (Exception ex) {
                ex.printStackTrace();
            }

        }
        return true;
    }

    public static void end_connection() {
        if (conn != null) {
            try {
                conn.close();
            } catch (SQLException ex) {
                //ex.printStackTrace();
            }
        }
    }
}
