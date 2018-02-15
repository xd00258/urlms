package ca.mcgill.ecse321.urlms.view;

import java.awt.BorderLayout;
import java.awt.Dimension;
import java.awt.Toolkit;
import java.awt.Window;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import javax.swing.JButton;
import javax.swing.JLabel;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JScrollPane;
import javax.swing.SwingConstants;
import javax.swing.JTextField;
import javax.swing.JTextPane;

public class MainPage extends JFrame {

	private JPanel contentPane;
	JLabel welcomeToUrlmsLabel;

	public static Controller controller = new Controller();
	public static StaffController staffController = new StaffController();
	private JButton btnStaff;
	private JButton btnFunding;
	private JButton btnSave;
	private JLabel lblFeelFreeTo;
	private JButton btnExit;
	private JTextPane txtpnBeforeUsingThis;

	/**
	 * Create the frame.
	 */
	public MainPage() {
		centerWindow(this);
		initComponents();
	}

	private void initComponents() {
		setTitle("URLMS Main Page");
		setResizable(false);
		setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		setBounds(100, 100, 620, 400);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(new BorderLayout(0, 0));

		JPanel panel = new JPanel();
		contentPane.add(panel, BorderLayout.SOUTH);

		btnStaff = new JButton("Staff");
		btnStaff.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent arg0) {
				StaffPagePO sppo = new StaffPagePO();
				sppo.setVisible(true);
			}
		});
		panel.add(btnStaff);

		JButton btnInventory = new JButton("Inventory");
		btnInventory.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				InventoryPagePO ippo = new InventoryPagePO();
				ippo.setVisible(true);
			}
		});
		panel.add(btnInventory);

		btnFunding = new JButton("Funding");
		btnFunding.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				FundingPagePO fppo = new FundingPagePO();
				fppo.setVisible(true);
			}
		});
		panel.add(btnFunding);

		btnSave = new JButton("Save");
		panel.add(btnSave);

		btnExit = new JButton("Exit");
		btnExit.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				exit();
			}
		});
		panel.add(btnExit);

		JScrollPane scrollPane = new JScrollPane();
		contentPane.add(scrollPane, BorderLayout.CENTER);

		lblFeelFreeTo = new JLabel("Feel free to check out the various amazing functionalites.");
		lblFeelFreeTo.setHorizontalAlignment(SwingConstants.CENTER);
		scrollPane.setColumnHeaderView(lblFeelFreeTo);

		txtpnBeforeUsingThis = new JTextPane();
		txtpnBeforeUsingThis.setEditable(false);
		txtpnBeforeUsingThis.setText(
				"\n\nBefore using this application, please note that this is a multi screen interactive program, meaning that pop out windows will appear as you navigate around. In order to experience the full potential of the features, please feel free to move around the pop out windows to search for information needed when effectuating actions. For example, editing staff member records requires the knowledge of the ID of the targeted staff member. To know which staff member the ID is associated with, refer to the Staff Page's View Staff List feature. \n\nAlso, before exiting the program, please use the Save button if you wish you save your actions. \n\nIf the data in the windows do not refresh instantly, please be patient or click on the View button again to refresh it manually. \n\nThank you for using the URLMS application! We hope to hear from you if you have any other questions. Please e-mail Team08 at feras.altaha@mail.mcgill.ca if you have any other concerns.");
		scrollPane.setViewportView(txtpnBeforeUsingThis);

		JPanel panel_1 = new JPanel();
		contentPane.add(panel_1, BorderLayout.NORTH);

		welcomeToUrlmsLabel = new JLabel("Welcome to URLMS.");
		panel_1.add(welcomeToUrlmsLabel);
		btnSave.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				controller.save();
				SavePO spo = new SavePO();
				spo.setVisible(true);
			}
		});
	}

	private void refreshData() {

	}

	private void exit() {
		System.exit(0);
	}

	public static void centerWindow(Window frame) {
		Dimension dimension = Toolkit.getDefaultToolkit().getScreenSize();
		int x = (int) ((dimension.getWidth() - frame.getWidth()) / 2);
		int y = (int) ((dimension.getHeight() - frame.getHeight()) / 2);
		frame.setLocation(x, y);
	}
}
