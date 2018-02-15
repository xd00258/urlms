package ca.mcgill.ecse321.urlms.view;

import java.awt.BorderLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.List;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.SwingConstants;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.ResearchRole;
import ca.mcgill.ecse321.urlms.model.StaffMember;

public class StaffPagePO extends JFrame {
	//JLabels
	JLabel staffMemberListLabel;
	JLabel feelFreeLabel;
	JLabel welcomeToStaffLabel;
	
	//JButtons
	JButton btnAddStaff;
	JButton btnEditStaffMember;
	JButton btnViewStaffList;
	JButton btnSave;
	private JButton btnClose;
	
	//Pop out pages
	public AddStaffMemberPO asmpo = new AddStaffMemberPO();
	public EditStaffMemberPO esmpo = new EditStaffMemberPO();
	public ProgressUpdatePO pupo = new ProgressUpdatePO();
	
	//JPanel
	private JPanel contentPane;

	//controller	
	public static StaffController controller = new StaffController();
	
	//error
	private String error;
	private JButton btnAddProgress;
	

	/**
	 * Create the frame.
	 */
	public StaffPagePO() {
		initComponents();
	}
	
	private void initComponents(){
		setTitle("Staff");
		setResizable(false);
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 640, 360);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(new BorderLayout(0, 0));
		
		JPanel panel = new JPanel();
		contentPane.add(panel, BorderLayout.SOUTH);
		btnAddStaff = new JButton("Add Staff");
		btnAddStaff.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				asmpo.setVisible(true);
			}
		});
		panel.add(btnAddStaff);
		
		btnEditStaffMember = new JButton("Edit Staff Member");
		btnEditStaffMember.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				esmpo.setVisible(true);
			}
		});
		panel.add(btnEditStaffMember);
		
		btnViewStaffList = new JButton("View Staff List");
		panel.add(btnViewStaffList);
		btnViewStaffList.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				
				
				staffMemberListLabel.setText("");				
				try {
					List<StaffMember> staffList = controller.viewStaffList();
					String name;
					int id;
					List<ResearchRole> roles;
					String roleString = "";

					staffMemberListLabel.setText("<html>");
					for (StaffMember aMember : staffList) {
						String previousText = staffMemberListLabel.getText();
						name = aMember.getName();
						id = aMember.getId();
						roles = aMember.getResearchRoles();
						for(ResearchRole role: roles) {
							roleString = roleString + role.getClass().getSimpleName() + " ";
						}
						
						
						staffMemberListLabel.setText(previousText + "Name: " + name + "&nbsp &nbsp &nbsp "
						+ "ID: " +  id + "&nbsp &nbsp &nbsp " + "Salary: $" +
								String.format("%.2f", aMember.getWeeklySalary()) + 
								 "&nbsp &nbsp &nbsp " + "Role(s): " +
								 roleString + " <br/>");
						
						roleString = "";
					}
					String previousText = staffMemberListLabel.getText();
					staffMemberListLabel.setText(previousText + "</html>");
				} catch (InvalidInputException e1) {
					error = e1.getMessage();
				}
				refreshData();
			}
		});
		
		btnAddProgress = new JButton("Staff Progress");
		btnAddProgress.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				
				pupo.setVisible(true);
			}
		});
		panel.add(btnAddProgress);
		
		btnSave = new JButton("Save");
		panel.add(btnSave);
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent arg0) {
				close();
			}
		});
		panel.add(btnClose);
		
		JScrollPane scrollPane = new JScrollPane();
		contentPane.add(scrollPane, BorderLayout.CENTER);
		
			
			staffMemberListLabel = new JLabel("");
			staffMemberListLabel.setHorizontalAlignment(SwingConstants.CENTER);
			scrollPane.setViewportView(staffMemberListLabel);
			
			feelFreeLabel = new JLabel("Feel free to try adding some staff, and then viewing them.");
			feelFreeLabel.setHorizontalAlignment(SwingConstants.CENTER);
			scrollPane.setColumnHeaderView(feelFreeLabel);
			
			JPanel panel_1 = new JPanel();
			contentPane.add(panel_1, BorderLayout.NORTH);
			welcomeToStaffLabel = new JLabel("Welcome to Staff. There's a lot of stuff.");
			panel_1.add(welcomeToStaffLabel);
			
		btnSave.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				controller.save();
				SavePO spo = new SavePO();
				spo.setVisible(true);
			}
		});
	}
	
	
	private void refreshData(){
		if(error.length() > 0){
			feelFreeLabel.setText(error);
		}
		else{
			feelFreeLabel.setText("Feel free to try adding some staff, and then viewing them.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
	
}
