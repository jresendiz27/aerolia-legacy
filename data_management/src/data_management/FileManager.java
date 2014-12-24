package data_management;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.util.ArrayList;

/**
 *
 * @author programming
 * @author alberto
 */
public class FileManager implements java.io.Serializable {

    private static ArrayList<HistoryContent> AHistory = null;
    private static ArrayList<EolikContent> AContent = null;

    public static ArrayList<HistoryContent> readLog() throws IOException {
        if (checkFile("History.dat")) {
            ObjectInputStream in = new ObjectInputStream(new FileInputStream("History.dat"));
            try {
                AHistory = (ArrayList<HistoryContent>) in.readObject();
            } catch (Exception e) {
            }
            return AHistory;
        } else {
            return AHistory = null;
        }

    }

    public static ArrayList<EolikContent> readData() throws IOException {
        if (checkFile("TempData.dat")) {
            ObjectInputStream in = new ObjectInputStream(new FileInputStream("TempData.dat"));
            try {
                AContent = (ArrayList<EolikContent>) in.readObject();
                return AContent;
            } catch (Exception e) {
                e.printStackTrace();
                return AContent = null;
            }
        } else {
            return AContent = null;
        }
    }

    public static void saveLog(HistoryContent hc) throws IOException {
        if (!checkFile("History.dat")) {
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("History.dat"));
            AHistory = new ArrayList<HistoryContent>();
            AHistory.add(hc);
            try {
                out.writeObject(AHistory);
                out.close();
            } catch (Exception e) {
            }
        } else {
            ArrayList<HistoryContent> read = readLog();
            read.add(hc);
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("History.dat"));
            try {
                out.writeObject(hc);
                out.close();
            } catch (Exception e) {
            }
        }

    }

    public static void saveLog(String desc, String main_data, int serial_number) {
        HistoryContent h = new HistoryContent();
        h.setError(desc);
        h.setContent(main_data);
        h.setDate(Tools.getDateTime());
        h.setSerial(serial_number);
        try {
            saveLog(h);
        } catch (Exception e) {
            //e.printStackTrace();
        }
    }

    public static void saveData(EolikContent ec) throws IOException {
        if (!checkFile("TempData.dat")) {
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("TempData.dat"));
            try {
                AContent = new ArrayList<EolikContent>();
                AContent.add(ec);
                out.writeObject(AContent);
                out.close();
            } catch (Exception e) {
            }
        } else {
            ArrayList<EolikContent> read = readData();
            read.add(ec);
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("TempData.dat"));
            try {
                out.writeObject(read);
                out.close();
            } catch (Exception e) {
            }
        }
    }

    public static void saveData(ArrayList<EolikContent> ec) throws IOException {
        if (!checkFile("TempData.dat")) {
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("TempData.dat"));
            try {
                AContent = ec;
                out.writeObject(AContent);
                out.close();
            } catch (Exception e) {
            }
        } else {
            ArrayList<EolikContent> read = readData();
            read.addAll(ec);
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("TempData.dat"));
            try {
                out.writeObject(read);
                out.close();
            } catch (Exception e) {
            }
        }
    }

    public static void saveLog(ArrayList<HistoryContent> ec) throws IOException {
        if (!checkFile("History.dat")) {
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("History.dat"));
            try {
                AHistory = ec;
                out.writeObject(AHistory);
                out.close();
            } catch (Exception e) {
            }
        } else {
            ArrayList<HistoryContent> read = readLog();
            read.addAll(ec);
            ObjectOutputStream out = new ObjectOutputStream(new FileOutputStream("History.dat"));
            try {
                out.writeObject(read);
                out.close();
            } catch (Exception e) {
            }
        }
    }

    public static boolean checkFile(String s) {
        File f = new File(s);
        boolean dato = f.canRead();
        if (dato) {
            return true;
        } else {
            return false;
        }
    }
}
