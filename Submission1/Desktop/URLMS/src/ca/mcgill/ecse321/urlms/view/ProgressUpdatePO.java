package ca.mcgill.ecse321.urlms.view;

import java.awt.BorderLayout;
import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.FundingController;
import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.Expense;
import ca.mcgill.ecse321.urlms.model.Lab;
import ca.mcgill.ecse321.urlms.model.ProgressUpdate;
import ca.mcgill.ecse321.urlms.model.StaffMember;
import ca.mcgill.ecse321.urlms.model.URLMS;

import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.LayoutStyle.ComponentPlacement;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.List;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;

import javax.swing.AbstractButton;
import javax.swing.BoxLayout;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.SwingConstants;
import javax.swing.JTextField;
import javax.swing.JCheckBox;

public class ProgressUpdatePO extends JFrame {
	JLabel progressUpdatesLabel;
	JLabel feelFreeLabel;
	private JPanel contentPane;
	JLabel welcomeToStaffLabel;
	String error;

	public AddProgressUpdatePopOut apupo = new AddProgressUpdatePopOut();
	JPanel panel = new JPanel();
	public static StaffController controller = new StaffController();
	private JTextField txtAccountName;
	JButton btnAddTransaction = new JButton("Add Progress Update");
	JButton btnViewStaffList = new JButton("View Staff Records");
	private JButton btnClose;

	/**
	 * Create the frame.
	 */
	public ProgressUpdatePO() {
		initComponents();
	}

	private void initComponents() {
		setTitle("Progress Updates");
		setResizable(false);
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 640, 360);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(new BorderLayout(0, 0));

		contentPane.add(panel, BorderLayout.SOUTH);

		btnAddTransaction.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {

				apupo.setVisible(true);
			}
		});
		panel.add(btnAddTransaction);

		txtAccountName = new JTextField();
		txtAccountName.setText("Staff ID to view");
		panel.add(txtAccountName);
		txtAccountName.setColumns(10);

		panel.add(btnViewStaffList);

		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent arg0) {
				close();
			}
		});
		panel.add(btnClose);
		btnViewStaffList.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				try {
					progressUpdatesLabel.setText("");
					int targetStaffID = Integer.valueOf(txtAccountName.getText());
					List<ProgressUpdate> updates = controller.viewProgressUpdateByID(targetStaffID);
					String description;
					String date;
					String staffMember = controller.getStaffMemberByID(targetStaffID).getName();
					progressUpdatesLabel.setText("<html>");
					progressUpdatesLabel.setText(progressUpdatesLabel.getText() + "Staff Member: " + staffMember
							+ "&nbsp &nbsp &nbsp " + "ID: " + controller.getStaffMemberByID(targetStaffID).getId()
							+ "&nbsp &nbsp &nbsp " + "Salary: $"
							+ String.format("%.2f", controller.getStaffMemberByID(targetStaffID).getWeeklySalary())
							+ " <br/>" + " <br/>" + " <br/>");
					for (ProgressUpdate aUpdate : updates) {
						String previousText = progressUpdatesLabel.getText();
						description = aUpdate.getDescription();
						date = aUpdate.getDate();
						progressUpdatesLabel.setText(previousText + "Date: " + date + "&nbsp &nbsp &nbsp "
								+ "Description: " + description + "&nbsp &nbsp &nbsp " + " <br/>");

					}
					String previousText = progressUpdatesLabel.getText();
					progressUpdatesLabel.setText(previousText + "</html>");
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				}
				catch (NumberFormatException e1) {
					error += "Please enter a valid ID. ";
				}
				catch (RuntimeException e1){
					error += "Other problems happened. ";
				}
				
				
				refreshData();
			}
		});

		JScrollPane scrollPane = new JScrollPane();
		contentPane.add(scrollPane, BorderLayout.CENTER);

		progressUpdatesLabel = new JLabel("");
		progressUpdatesLabel.setHorizontalAlignment(SwingConstants.CENTER);
		scrollPane.setViewportView(progressUpdatesLabel);

		feelFreeLabel = new JLabel("Feel free to try adding some staff, and then viewing them.");
		feelFreeLabel.setHorizontalAlignment(SwingConstants.CENTER);
		scrollPane.setColumnHeaderView(feelFreeLabel);

		JPanel panel_1 = new JPanel();
		contentPane.add(panel_1, BorderLayout.NORTH);
		welcomeToStaffLabel = new JLabel("Welcome to Staff. There's a lot of stuff.");
		panel_1.add(welcomeToStaffLabel);
	}

	public void close() {
		this.setVisible(false);
		this.dispose();
	}

	private void refreshData() {
		if (error.length() > 0) {
			feelFreeLabel.setText(error);
		} else {
			feelFreeLabel.setText("Add progress updates or view staff records.");
		}
	}
}
